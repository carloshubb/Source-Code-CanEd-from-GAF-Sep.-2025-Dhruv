import ErrorHandling from "../../ErrorHandling";

const admission_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            employees_pre_description: {},
            employees_post_description: {},
            team_pre_description: {},
            team_post_description: {},
            admission_apply_button_link: "",
            admission_apply_button_title: "",
            admission_red_bar_button_link: "",
            admission_red_bar_button_title: "",
            admission_blue_bar_button_link: "",
            admission_blue_bar_button_title: "",
            faq_pre_description: {},
            faq_post_description: {},
            languages: [],
            customer_id: "",
            school_id: "",
        },
        admission_setting: null,
        loading: false,
        limit: 10,
    },
    mutations: {
        setLanguages(state, payload) {
            state.form.languages = payload;
        },
        setPageSetting(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updatePageSetting(state, payload) {
            if (typeof state.form[payload.key] !== 'object' || state.form[payload.key] === null) {
                state.form[payload.key] = {};
            }
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },
        setAdmissionSetting(state, payload) {
            state.admission_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                employees_pre_description: {},
                employees_post_description: {},
                team_pre_description: {},
                admission_apply_button_link: "",
                admission_apply_button_title: "",
                admission_red_bar_button_link: "",
                admission_red_bar_button_title: "",
                admission_blue_bar_button_link: "",
                admission_blue_bar_button_title: "",
                team_post_description: {},
                faq_pre_description: {},
                faq_post_description: {},
                customer_id: "",
                school_id: "",
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
        },
        setForm(state, payload) {
            state.form.id = payload?.id || null;
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
            let url = `${process.env.MIX_WEB_API_URL}admission-setting`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessage(res.data.message);
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
        fetchAdmissionSetting({ commit, state }, payload) {
            let url = payload.url;
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
    },
};

export default admission_setting;
