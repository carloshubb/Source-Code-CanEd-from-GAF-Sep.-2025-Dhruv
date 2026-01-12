import ErrorHandling from "../../ErrorHandling";

const webinars = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            title: "",
            description: "",
            start_date: "",
            everyone_can_speak: "",
            detailed_registration_page_enabled: "",
            light_registration_page_enabled: "",
            recording_enabled: "",
            chat_enabled: "",
            questions_enabled: "",
            polls_enabled: "",
            image: "",
            timezone: "Asia/Calcutta"
        },
        webinars: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
        showModal: false,
    },
    mutations: {
        setForData(state, payload) {
            if (payload?.language?.id) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.id
                ] = payload?.value;
            } else {
                state.form[payload?.key] = payload?.value;
            }
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setWebinar(state, payload) {
            state.form[payload?.key] = payload?.value;
        },
        setWebinars(state, payload) {
            state.webinars = payload;
        },
        setPagination(state, pagination) {
            if (pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page,
                    last_page: pagination.meta.last_page,
                    next_page_url: pagination.links
                        ? pagination.links.next
                        : null,
                    prev_page_url: pagination.links
                        ? pagination.links.prev
                        : null,
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
        resetForm(state) {
            state.form = {
                id: null,
                title: "",
                description: "",
                start_date: "",
                everyone_can_speak: "",
                detailed_registration_page_enabled: "",
                light_registration_page_enabled: "",
                recording_enabled: "",
                chat_enabled: "",
                questions_enabled: "",
                polls_enabled: "",
                image: "",
                timezone: "Asia/Calcutta",
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
            state.showModal = false;
        },
        setForm(state, payload) {
            state.form.id = payload.id;
        },
        setValidationErros(state, payload) {
            state.validationErros.record(payload);
        },
        setEmptyError(state) {
            state.validationErros = new ErrorHandling();
        },
        setError(state, payload) {
            state.error = payload;
        }
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_WEB_API_URL}webinars/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}webinars`;
            commit("setLoading");

            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            commit("resetForm");
                            resolve(res);
                        } else {
                            resolve(res);
                            // helper.swalErrorMessage(res.data.message);
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
        fetchWebinars({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}webinars?withWebinarDetail=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setWebinars", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchWebinar({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}webinars/${payload.id}?withWebinarDetail=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        console.log('webinar' ,res);
                        if (res.data.status == "Success") {
                            commit("setWebinar", {
                                key: "timezone",
                                value: res.data.data.timezone,
                            });
                            commit("setWebinar", {
                                key: "start_date",
                                value: res.data.data.start_date,
                            });
                            commit("setWebinar", {
                                key: "title",
                                value: res.data.data.title,
                            });
                            commit("setWebinar", {
                                key: "image",
                                value: res.data.data.image,
                            });
                            let live_strom_webinar = JSON.parse(res.data.data.live_strom_webinar);
                            console.log(live_strom_webinar,"webinars data");
                            commit("setWebinar", {
                                key: "everyone_can_speak",
                                value: live_strom_webinar?.data?.attributes?.everyone_can_speak ? 1 : 0,
                            });
                            commit("setWebinar", {
                                key: "detailed_registration_page_enabled",
                                value: live_strom_webinar?.data?.attributes?.detailed_registration_page_enabled ? 1 : 0,
                            });
                            commit("setWebinar", {
                                key: "light_registration_page_enabled",
                                value: live_strom_webinar?.data?.attributes?.light_registration_page_enabled ? 1 : 0,
                            });

                            commit("setWebinar", {
                                key: "recording_enabled",
                                value: live_strom_webinar?.data?.attributes?.recording_enabled ? 1 : 0,
                            });

                            commit("setWebinar", {
                                key: "chat_enabled",
                                value: live_strom_webinar?.data?.attributes?.chat_enabled ? 1 : 0,
                            });

                            commit("setWebinar", {
                                key: "questions_enabled",
                                value: live_strom_webinar?.data?.attributes?.questions_enabled ? 1 : 0,
                            });

                            commit("setWebinar", {
                                key: "polls_enabled",
                                value: live_strom_webinar?.data?.attributes?.polls_enabled ? 1 : 0,
                            });

                            commit("setWebinar", {
                                key: "description",
                                value: live_strom_webinar?.data?.attributes?.description,
                            });

                            commit("setWebinar", {
                                key: "timezone",
                                value: live_strom_webinar?.included[0]?.attributes?.timezone,
                            });
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteWebinar({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}webinars/${payload.id}`;
            return new Promise(function (resolve, reject) {
                axios
                    .delete(url)
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

export default webinars;
