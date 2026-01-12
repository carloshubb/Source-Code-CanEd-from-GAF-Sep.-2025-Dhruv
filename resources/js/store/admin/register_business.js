import ErrorHandling from "../../ErrorHandling";

const register_business = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            page_title: {},
            package_section_title: {},
            business_category_text: {},
            business_category_1_lable: {},
            business_category_1_placeholder: {},
            business_category_1_error: {},
            business_category_2_lable: {},
            business_category_2_placeholder: {},
            business_category_2_error: {},
            business_category_3_lable: {},
            business_category_3_placeholder: {},
            business_category_3_error: {},
            description_lable: {},
            description_placeholder: {},
            description_error: {},
            detail_description_lable: {},
            detail_description_placeholder: {},
            detail_description_error: {},
            name_lable: {},
            name_placeholder: {},
            name_error: {},
            website_url_lable: {},
            website_url_placeholder: {},
            website_url_error: {},
            contact_lable: {},
            contact_placeholder: {},
            contact_error: {},
            email_lable: {},
            email_placeholder: {},
            email_error: {},
            phone_lable: {},
            phone_placeholder: {},
            phone_error: {},
            address_lable: {},
            address_placeholder: {},
            address_error: {},
            logo_error: {},
            logo_placeholder: {},
            logo_lable: {},
            media_title: {},
            media_title_label: {},
            media_title_placeholder: {},
            media_title_error: {},
            media_description_label: {},
            media_description_placeholder: {},
            media_description_error: {},
            file_lable: {},
            file_placeholder: {},
            file_error: {},
            facebook_lable: {},
            facebook_placeholder: {},
            facebook_error: {},
            twitter_lable: {},
            twitter_placeholder: {},
            twitter_error: {},
            youtube_lable: {},
            youtube_placeholder: {},
            youtube_error: {},
            linkedin_lable: {},
            linkedin_placeholder: {},
            linkedin_error: {},
            privacy_text_1: {},
            privacy_text_2: {},
            proceed_button_text: {},
            social_media_title: {},
            registration_package_heading_text: {},
            social_media_heading_text: {},
            media_heading_text: {},
            business_category_heading_text: {},
            business_profile_heading_text: {},
        },
        register_business: null,
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
        setRegisterBusiness(state, payload) {
            state.register_business = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                page_title: {},
                package_section_title: {},
                business_category_text: {},
                business_category_1_lable: {},
                business_category_1_placeholder: {},
                business_category_1_error: {},
                business_category_2_lable: {},
                business_category_2_placeholder: {},
                business_category_2_error: {},
                business_category_3_lable: {},
                business_category_3_placeholder: {},
                business_category_3_error: {},
                description_lable: {},
                description_placeholder: {},
                description_error: {},
                detail_description_lable: {},
                detail_description_placeholder: {},
                detail_description_error: {},
                name_lable: {},
                name_placeholder: {},
                name_error: {},
                website_url_lable: {},
                website_url_placeholder: {},
                website_url_error: {},
                contact_lable: {},
                contact_placeholder: {},
                contact_error: {},
                email_lable: {},
                email_placeholder: {},
                email_error: {},
                phone_lable: {},
                phone_placeholder: {},
                phone_error: {},
                address_lable: {},
                address_placeholder: {},
                address_error: {},
                logo_error: {},
                logo_placeholder: {},
                logo_lable: {},
                media_title: {},
                media_title_label: {},
                media_title_placeholder: {},
                media_title_error: {},
                media_description_label: {},
                media_description_placeholder: {},
                media_description_error: {},
                file_lable: {},
                file_placeholder: {},
                file_error: {},
                facebook_lable: {},
                facebook_placeholder: {},
                facebook_error: {},
                twitter_lable: {},
                twitter_placeholder: {},
                twitter_error: {},
                youtube_lable: {},
                youtube_placeholder: {},
                youtube_error: {},
                linkedin_lable: {},
                linkedin_placeholder: {},
                linkedin_error: {},
                privacy_text_1: {},
                privacy_text_2: {},
                proceed_button_text: {},
                social_media_title: {},
                registration_package_heading_text: {},
                social_media_heading_text: {},
                media_heading_text: {},
                business_category_heading_text: {},
                business_profile_heading_text: {},
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
            let url = `${process.env.MIX_ADMIN_API_URL}register-business`;
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
        fetchRegisterBusiness({ commit, state }, payload) {
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

export default register_business;
