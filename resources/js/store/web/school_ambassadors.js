import ErrorHandling from "../../ErrorHandling";

const school_ambassadors = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            image: "",
            region: "",
            province: "",
            title: "",
            city: "",
            langs: "",
            degree_level: "",
            is_checked: "",
            fav_module: "",
            hobies_interests: "",
            societies: "",
            email: "",
            password: "",
            category: "",
            customer_id: "",
            school_id: "",
            whats_app_number: "",
            skype_id: "",
            we_chat_number: "",
            viber_number: "",
            imo_number: "",
            mobile_number: "",
            message_number: "",
            my_major: "",
            I_study_here: "",
            my_minor: "",
            status: "active",
            name: {},
            about_me: {},
            languages: [],
            messaging_apps: {}, 
        },
        school_ambassadors: null,
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
        setLanguages(state, payload) {
            state.form.languages = payload;
        },
        setForData(state, payload) {
            if (payload?.language?.language_code) {
                // Handle nested language-specific fields
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.language_code
                ] = payload?.value;
            } else if (payload?.key === "messaging_apps") {
                // Handle nested messaging_apps object
                state.form[payload.key] = payload.value;
            } else {
                // Handle regular fields
                state.form[payload?.key] = payload?.value;
            }
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
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setSchoolAmbassador(state, payload) {
            const {
                id,
                image,
                region,
                province,
                is_checked,
                city,
                langs,
                degree_level,
                fav_module,
                hobies_interests,
                societies,
                email,
                password,
                category,
                whats_app_number,
                skype_id,
                we_chat_number,
                viber_number,
                imo_number,
                mobile_number,
                message_number,
                I_study_here,
                my_major,
                title,
                my_minor,
                status,
                messaging_apps
            } = payload;
            state.form["id"] = id;
            state.form["image"] = image;
            state.form["region"] = region;
            state.form["city"] = city;
            state.form["title"] = title;
            state.form["province"] = province;
            state.form["is_checked"] = is_checked;
            state.form["langs"] = langs;
            state.form["I_study_here"] = I_study_here;
            state.form["degree_level"] = degree_level;
            state.form["fav_module"] = fav_module;
            state.form["hobies_interests"] = hobies_interests;
            state.form["societies"] = societies;
            state.form["societies"] = societies;
            state.form["email"] = email;
            state.form["password"] = password;
            state.form["category"] = category;
            state.form["whats_app_number"] = whats_app_number;
            state.form["skype_id"] = skype_id;
            state.form["we_chat_number"] = we_chat_number;
            state.form["viber_number"] = viber_number;
            state.form["imo_number"] = imo_number;
            state.form["mobile_number"] = mobile_number;
            state.form["message_number"] = message_number;
            state.form["my_major"] = my_major;
            state.form["my_minor"] = my_minor;
            state.form["status"] = status;
            state.form["messaging_apps"] = messaging_apps || {};

            for (
                let i = 0;
                i < payload?.school_ambassador_detail?.length;
                i++
            ) {
                if (
                    payload?.school_ambassador_detail[i] &&
                    payload?.school_ambassador_detail[i]?.language_code
                ) {
                    state.form["about_me"][
                        "about_me" +
                        "_" +
                        payload?.school_ambassador_detail[i]?.language_code
                    ] = payload?.school_ambassador_detail[i]?.about_me;
                    state.form["name"][
                        "name" +
                        "_" +
                        payload?.school_ambassador_detail[i]?.language_code
                    ] = payload?.school_ambassador_detail[i]?.name;
                }
            }
            state.isFormEdit = true;
            state.showModal = true;
        },
        setSchoolAmbassadors(state, payload) {
            state.school_ambassadors = payload;
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
                image: "",
                region: "",
                province: "",
                city: "",
                title: "",
                langs: "",
                I_study_here: "",
                degree_level: "",
                fav_module: "",
                hobies_interests: "",
                societies: "",
                is_checked: "",
                email: "",
                password: "",
                category: "",
                customer_id: "",
                school_id: "",
                whats_app_number: "",
                skype_id: "",
                we_chat_number: "",
                viber_number: "",
                imo_number: "",
                mobile_number: "",
                message_number: "",
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
            state.showModal = false;
        },
        setUrl(state, payload) {
            state.form.url = payload;
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
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_WEB_API_URL}school_ambassadors/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school_ambassadors`;
            commit("setLoading");

            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else {
                            // helper.swalErrorMessage(res.data.message);
                            resolve(res);
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
        fetchSchoolAmbassadors({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school_ambassadors?withSchoolAmbassadorDetail=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolAmbassadors", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolAmbassador({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school_ambassadors/${payload.id}?withSchoolAmbassadorDetail=1&withMessagingApps=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        console.log('stateRes', res);
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            commit("setSchoolAmbassador", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteSchoolAmbassador({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school_ambassadors/${payload.id}`;
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
    },
};

export default school_ambassadors;
