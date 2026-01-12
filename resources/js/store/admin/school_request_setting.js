import ErrorHandling from "../../ErrorHandling";

const school_request_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            page_title: {},
            name_label: {},
            name_placeholder: {},
            name_error: {},
            description_label: {},
            description_placeholder: {},
            description_error: {},
            website_label: {},
            website_placeholder: {},
            website_error: {},
            email_label: {},
            email_placeholder: {},
            email_error: {},
            phone_label: {},
            phone_placeholder: {},
            phone_error: {},
            time_label: {},
            time_placeholder: {},
            time_error: {},
            time_zone_label: {},
            time_zone_placeholder: {},
            time_zone_error: {},
            province_label: {},
            province_placeholder: {},
            province_error: {},
            country_label: {},
            country_placeholder: {},
            country_error: {},
            city_label: {},
            city_placeholder: {},
            city_error: {},
            description: {},
            protect_your_account_text: {},
            protect_your_account_description: {},
            submit_button_text: {},
            image_upload_label: {},
            image_upload_placeholder: {},
            image_upload_error: {},
        },
        school_request_setting: null,
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
        setSchoolRequestSetting(state, payload) {
            state.school_request_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                page_title: {},
                page_title: {},
                name_label: {},
                name_placeholder: {},
                name_error: {},
                description_label: {},
                description_placeholder: {},
                description_error: {},
                website_label: {},
                website_placeholder: {},
                website_error: {},
                email_label: {},
                email_placeholder: {},
                email_error: {},
                phone_label: {},
                phone_placeholder: {},
                phone_error: {},
                time_label: {},
                time_placeholder: {},
                time_error: {},
                time_zone_label: {},
                time_zone_placeholder: {},
                time_zone_error: {},
                province_label: {},
                province_placeholder: {},
                province_error: {},
                country_label: {},
                country_placeholder: {},
                country_error: {},
                city_label: {},
                city_placeholder: {},
                city_error: {},
                description: {},
                protect_your_account_text: {},
                protect_your_account_description: {},
                submit_button_text: {},
                image_upload_label: {},
                image_upload_placeholder: {},
                image_upload_error: {},
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
            let url = `${process.env.MIX_ADMIN_API_URL}school-request-setting`;
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
        fetchSchoolRequestSetting({ commit, state }, payload) {
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

export default school_request_setting;
