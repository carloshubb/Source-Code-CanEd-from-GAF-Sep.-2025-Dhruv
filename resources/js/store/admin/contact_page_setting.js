import ErrorHandling from "../../ErrorHandling";

const contact_page_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            page_title_1: {},
            page_title_2: {},
            description: {},
            mainling_address: {},
            toll_free: {},
            phone: {},
            email: {},
            website: {},
            mainling_address_lable: {},
            toll_free_lable: {},
            phone_lable: {},
            email_lable: {},
            website_lable: {},
            name_input_lable: {},
            name_input_placeholder: {},
            name_input_error: {},
            email_input_lable: {},
            email_input_placeholder: {},
            email_input_error: {},
            message_input_lable: {},
            message_input_placeholder: {},
            message_input_error: {},
            button_text: {},
        },
        contact_page_setting: null,
        loading: false,
        limit: 10,
    },
    mutations: {
        setPageSetting(state, payload){
             
            state.form[payload.key] = payload.value;
        },
        updatePageSetting(state, payload){
            if (typeof state.form[payload.key] !== 'object' || state.form[payload.key] === null) {
                state.form[payload.key] = {};
            }
            state.form[payload.key][`${payload.key}_${payload.id}`] = payload.value;
        },
        setContactPageSetting(state, payload) {
            state.contact_page_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                page_title_1: {},
                page_title_2: {},
                description: {},
                mainling_address: {},
                toll_free: {},
                phone: {},
                email: {},
                website: {},
                mainling_address_lable: {},
                toll_free_lable: {},
                phone_lable: {},
                email_lable: {},
                website_lable: {},
                name_input_lable: {},
                name_input_placeholder: {},
                name_input_error: {},
                email_input_lable: {},
                email_input_placeholder: {},
                email_input_error: {},
                message_input_lable: {},
                message_input_placeholder: {},
                message_input_error: {},
                button_text: {},
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
        },
        setForm(state, payload) {
            state.form.id = payload.id
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
            let url = `${process.env.MIX_ADMIN_API_URL}contact-page-setting`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, state.form)
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
                            commit("setValidationErros", error.response.data.errors);
                            helper.swalErrorMessage("you missed required fields please check all language tabs");
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchContactPageSetting({ commit, state }, payload) {
            let url = payload.url;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
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

export default contact_page_setting;
