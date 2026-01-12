import ErrorHandling from "../../ErrorHandling";

const login_page_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            page_title: {},
            login_email_label: {},
            login_email_placeholder: {},
            login_email_error: {},
            login_passowrd_label: {},
            login_passowrd_placeholder: {},
            login_passowrd_error: {},
            keep_me_logged_in_text: {},
            forget_password_text: {},
            login_button_text: {},
            not_register_yet_text: {},
            create_account_button_text: {},
            protect_your_account_text: {},
            protect_your_account_description: {},
            facebook_login_text:{},
            google_login_text:{},
            linkedin_login_text:{},
            email_format_error_text:{},
            credentails_match_error_text:{},
        },
        login_page_setting: null,
        loading: false,
        limit: 10,
    },
    mutations: {
        setPageSetting(state, payload) {
             
            state.form[payload.key] = payload.value;
        },
        updatePageSetting(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },
        setLoginPageSetting(state, payload) {
            state.login_page_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                page_title: {},
                login_email_label: {},
                login_email_placeholder: {},
                login_email_error: {},
                login_passowrd_label: {},
                login_passowrd_placeholder: {},
                login_passowrd_error: {},
                keep_me_logged_in_text: {},
                forget_password_text: {},
                login_button_text: {},
                not_register_yet_text: {},
                create_account_button_text: {},
                protect_your_account_text: {},
                protect_your_account_description: {},
                facebook_login_text:{},
                google_login_text:{},
                linkedin_login_text:{},
                email_format_error_text:{},
                credentails_match_error_text:{},
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
            let url = `${process.env.MIX_ADMIN_API_URL}login-page-setting`;
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
        fetchLoginPageSetting({ commit, state }, payload) {
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

export default login_page_setting;
