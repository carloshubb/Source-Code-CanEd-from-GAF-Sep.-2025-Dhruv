import ErrorHandling from "../../ErrorHandling";

const career_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            title: {},
            page_title: {},
            article_title: {},
            tab_1_title: {},
            tab_2_title: {},
            tab_3_title: {},
            search_input_placeholder: {},
            description: {},
        },
        career_setting: null,
        loading: false,
        limit: 10,
    },
    mutations: {
        setCareerSetting(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateCareerSetting(state, payload) {
            if (typeof state.form[payload.key] !== 'object' || state.form[payload.key] === null) {
                state.form[payload.key] = {};
            }
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },
        setCareerSettingObject(state, payload) {
            state.career_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                title: {},
                page_title: {},
                article_title: {},
                tab_1_title: {},
                tab_2_title: {},
                tab_3_title: {},
                search_input_placeholder: {},
                description: {},
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
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
            let url = `${process.env.MIX_ADMIN_API_URL}career-settings`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
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
                            helper.swalErrorMessage("you missed required fields please check all language tabs");
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
        fetchCareerSetting({ commit, state }, payload) {
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

export default career_setting;
