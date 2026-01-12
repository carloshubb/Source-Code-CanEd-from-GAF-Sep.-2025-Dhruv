import ErrorHandling from "../../ErrorHandling";
import { createApp } from 'vue';
const ambassadors = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            region: "",
            image: "",
            province: "",
            city: "",
            degree_level: "",
            fav_module: "",
            hobies_interests: "",
            societies: "",
            langs: "",
            whats_app_number: "",
            skype_id: "",
            we_chat_number: "",
            viber_number: "",
            imo_number: "",
            mobile_number: "",
            I_study_here: "",
            email: "",
            category: "",
            my_major: "",
            my_minor: "",
            status: "",
            name: {},
            about_me: {},
            languages: [],
            messaging_apps: {},
        },
        ambassadors: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "",
        isFormEdit: false,
    },
    mutations: {
        // setLanguages(state, payload) {
        //     state.form.languages = payload;
        // },
        // setForData(state, payload) {
        //     console.log("Updating state for:", payload.key, payload.language, payload.value);

        //     if (payload?.language?.language_code) {
        //         state.form[payload.key][`${payload.key}_${payload.language.language_code}`] = payload.value;
        //     } else {
        //         state.form[payload.key] = payload.value;
        //     }
        // },
        setLanguages(state, payload) {
            state.form.languages = payload;
        },
        setForData(state, payload) {
            if (payload?.language?.language_code) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.language_code
                ] = payload?.value;
            } else if (payload?.key === "messaging_apps") {
                // Handle nested messaging_apps object
                state.form[payload.key] = payload.value;
            } else {
                state.form[payload?.key] = payload?.value;
            }
        },

        setState(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateState(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] = payload.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setSchoolScholarships(state, payload) {
            state.ambassadors = payload;
        },
        setPagination(state, pagination) {
            if (pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page,
                    last_page: pagination.meta.last_page,
                    next_page_url: pagination.links ? pagination.links.next : null,
                    prev_page_url: pagination.links ? pagination.links.prev : null,
                    base_url: pagination.meta.path,
                    first_page_url: pagination.links.first,
                };
            }
        },
        setSearchParam(state, payload) {
            state.searchParam = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "searchParam",
                payload
            );
        },
        setLimit(state, payload) {
            state.limit = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "limit",
                payload
            );
        },
        setSortBy(state, payload) {
            state.sortBy = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "sortBy",
                payload
            );
        },
        setSortType(state, payload) {
            state.sortType = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "sortType",
                payload
            );
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        updateMessageApp(state, payload) {
            Object.keys(state.form.messaging_apps).forEach(key => {
                if (!payload.includes(Number(key))) {
                    delete state.form.messaging_apps[key];
                }
            });
        },
        resetForm(state) {
            state.form = {
                id: null,
                region: "",
                image: "",
                province: "",
                city: "",
                degree_level: "",
                I_study_here: "",
                fav_module: "",
                hobies_interests: "",
                societies: "",
                langs: "",
                whats_app_number: "",
                skype_id: "",
                we_chat_number: "",
                viber_number: "",
                imo_number: "",
                mobile_number: "",
                email: "",
                category: "",
                my_major: "",
                my_minor: "",
                status: "",
                name: {},
                about_me: {},
                languages: [],
                messaging_apps: {},

            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
        },
        setUrl(state, payload) {
            state.form.url = payload;
        },
        // setForData(state, payload) {
        //     if (payload?.language?.language_code) {
        //         state.form[payload?.key][
        //             payload?.key + "_" + payload?.language?.language_code
        //         ] = payload?.value;
        //     } else {
        //         state.form[payload?.key] = payload?.value;
        //     }
        // },
        setForm(state, payload) {

            state.form.id = payload.id;
            state.form.image = payload.image;
        },
        setValidationErros(state, payload) {
            state.validationErros.record(payload);
        },
        setEmptyError(state) {
            state.validationErros = new ErrorHandling();
        },
        setError(state, payload) {
            state.error = payload;
        },
        updateMessagingApp(state, { appId, value }) {
            // Update the messaging_apps field for the respective appId
            state.form.messaging_apps[appId] = value;
        },

        clearMessagingApp(state, appId) {
            // Clear the messaging_apps field for the respective appId
            // Vue.delete(state.form.messaging_apps, appId);
            delete state.form.messaging_apps[appId];

        },

    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}ambassadors/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}ambassadors`;
            commit("setLoading");
            // state.form.languages = state.languages;

            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            commit("resetForm");
                            commit("setLanguages");
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setValidationErros",
                                error.response.data.errors
                            );
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchAmbassadors({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}ambassadors?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolScholarships", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchAmbassador({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}ambassadors/${payload.id}?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteOpenDay({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}ambassadors/${payload.id}`;
            return axios
                .delete(url, {
                    data: { password: payload.password },
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        return res;
                    } else if (res.data.status == "Error") {
                        helper.swalErrorMessage(res.data.message);
                        throw new Error(res.data.message);
                    }
                })
                .catch(error => {
                    throw error;
                })
                .finally(() => commit("setLoading"));
        },
        deactiveOpenDay({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}ambassadors/deactive-school`;
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else if (res.data.status == "Error") {
                            helper.swalErrorMessage(res.data.message);
                            resolve(res);
                        }
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    },
};

export default ambassadors;
