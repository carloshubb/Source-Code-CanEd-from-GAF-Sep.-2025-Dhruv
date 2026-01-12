import ErrorHandling from "../../ErrorHandling";

const master_application_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            page_title: {},
            description: {},
            school_lable: {},
            school_placeholder: {},
            school_error: {},
            first_name_label: {},
            first_name_placeholder: {},
            first_name_error: {},
            last_name_label: {},
            last_name_placeholder: {},
            last_name_error: {},
            email_label: {},
            email_placeholder: {},
            email_error: {},
            confirm_email_label: {},
            confirm_email_placeholder: {},
            confirm_email_error: {},
            dob_label: {},
            dob_placeholder: {},
            dob_error: {},
            button_text: {},
            gender_label: {},
            gender_placeholder: {},
            gender_error: {},
            phone_label: {},
            phone_placeholder: {},
            phone_error: {},
            can_school_text_label: {},
            can_school_text_placeholder: {},
            can_school_text_error: {},
            message_app_label: {},
            message_app_placeholder: {},
            message_app_error: {},
            message_app_username_label: {},
            message_app_username_placeholder: {},
            message_app_username_error: {},
            currently_study_label: {},
            currently_study_placeholder: {},
            currently_study_error: {},
            country_citzenship_label: {},
            country_citzenship_placeholder: {},
            country_citzenship_error: {},
            live_in_country_citzenship_label: {},
            live_in_country_citzenship_placeholder: {},
            live_in_country_citzenship_error: {},
            current_residence_label: {},
            current_residence_placeholder: {},
            current_residence_error: {},
            country_residence_status_label: {},
            country_residence_status_placeholder: {},
            country_residence_status_error: {},
            mailing_address_label: {},
            mailing_address_placeholder: {},
            mailing_address_error: {},
            high_school_name_label: {},
            high_school_name_placeholder: {},
            high_school_name_error: {},
            letter_of_intent_label: {},
            letter_of_intent_placeholder: {},
            letter_of_intent_error: {},
            statement_of_purpose_label: {},
            statement_of_purpose_placeholder: {},
            statement_of_purpose_error: {},
            when_plan_to_start_label: {},
            when_plan_to_start_placeholder: {},
            when_plan_to_start_error: {},
            intrested_in_label: {},
            intrested_in_placeholder: {},
            intrested_in_error: {},
            would_like_to_study_label: {},
            would_like_to_study_placeholder: {},
            would_like_to_study_error: {},
            tuition_funding_source_label: {},
            tuition_funding_source_placeholder: {},
            tuition_funding_source_error: {},
            test_taken_label: {},
            test_taken_placeholder: {},
            test_taken_error: {},
            additional_label: {},
            additional_placeholder: {},
            additional_error: {},
            add_something_lable: {},
            add_something_placeholder: {},
            add_something_error: {},
            currently_live_in_lable: {},
            currently_live_in_placeholder: {},
            currently_live_in_error: {},
            study_permet_lable: {},
            study_permet_placeholder: {},
            study_permet_error: {},
            send_copy_lable: {},
            send_copy_placeholder: {},
            send_copy_error: {},
            button_text: {},
            where_want_to_study_lable: {},
            where_want_to_study_placeholder: {},
            where_want_to_study_error: {},
            high_school_city_lable: {},
            high_school_city_placeholder: {},
            high_school_city_error: {},
            high_school_cgpa_lable: {},
            high_school_cgpa_placeholder: {},
            high_school_cgpa_error: {},
            high_school_country_lable: {},
            high_school_country_placeholder: {},
            high_school_country_error: {},
            student_type_lable: {},
            student_type_placeholder: {},
            student_type_error: {},
            privacy_policy: {},
        },
        master_application_setting: null,
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
        setMasterApplicationSetting(state, payload) {
            state.master_application_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                page_title: {},
                description: {},
                school_lable: {},
                school_placeholder: {},
                school_error: {},
                first_name_label: {},
                first_name_placeholder: {},
                first_name_error: {},
                last_name_label: {},
                last_name_placeholder: {},
                last_name_error: {},
                email_label: {},
                email_placeholder: {},
                email_error: {},
                confirm_email_label: {},
                confirm_email_placeholder: {},
                confirm_email_error: {},
                dob_label: {},
                dob_placeholder: {},
                dob_error: {},
                button_text: {},
                gender_label: {},
                gender_placeholder: {},
                gender_error: {},
                phone_label: {},
                phone_placeholder: {},
                phone_error: {},
                can_school_text_label: {},
                can_school_text_placeholder: {},
                can_school_text_error: {},
                message_app_label: {},
                message_app_placeholder: {},
                message_app_error: {},
                message_app_username_label: {},
                message_app_username_placeholder: {},
                message_app_username_error: {},
                currently_study_label: {},
                currently_study_placeholder: {},
                currently_study_error: {},
                country_citzenship_label: {},
                country_citzenship_placeholder: {},
                country_citzenship_error: {},
                live_in_country_citzenship_label: {},
                live_in_country_citzenship_placeholder: {},
                live_in_country_citzenship_error: {},
                current_residence_label: {},
                current_residence_placeholder: {},
                current_residence_error: {},
                country_residence_status_label: {},
                country_residence_status_placeholder: {},
                country_residence_status_error: {},
                mailing_address_label: {},
                mailing_address_placeholder: {},
                mailing_address_error: {},
                high_school_name_label: {},
                high_school_name_placeholder: {},
                high_school_name_error: {},
                letter_of_intent_label: {},
                letter_of_intent_placeholder: {},
                letter_of_intent_error: {},
                statement_of_purpose_label: {},
                statement_of_purpose_placeholder: {},
                statement_of_purpose_error: {},
                when_plan_to_start_label: {},
                when_plan_to_start_placeholder: {},
                when_plan_to_start_error: {},
                intrested_in_label: {},
                intrested_in_placeholder: {},
                intrested_in_error: {},
                would_like_to_study_label: {},
                would_like_to_study_placeholder: {},
                would_like_to_study_error: {},
                tuition_funding_source_label: {},
                tuition_funding_source_placeholder: {},
                tuition_funding_source_error: {},
                test_taken_label: {},
                test_taken_placeholder: {},
                test_taken_error: {},
                additional_label: {},
                additional_placeholder: {},
                additional_error: {},
                add_something_lable: {},
                add_something_placeholder: {},
                add_something_error: {},
                currently_live_in_lable: {},
                currently_live_in_placeholder: {},
                currently_live_in_error: {},
                study_permet_lable: {},
                study_permet_placeholder: {},
                study_permet_error: {},
                send_copy_lable: {},
                send_copy_placeholder: {},
                send_copy_error: {},
                button_text: {},
                where_want_to_study_lable: {},
                where_want_to_study_placeholder: {},
                where_want_to_study_error: {},
                high_school_city_lable: {},
                high_school_city_placeholder: {},
                high_school_city_error: {},
                high_school_country_lable: {},
                high_school_country_placeholder: {},
                high_school_country_error: {},
                high_school_cgpa_lable: {},
                high_school_cgpa_placeholder: {},
                high_school_cgpa_error: {},
                student_type_lable: {},
                student_type_placeholder: {},
                student_type_error: {},
                privacy_policy: {},
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
            let url = `${process.env.MIX_ADMIN_API_URL}master-application-setting`;
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
        fetchMasterApplicationSetting({ commit, state }, payload) {
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

export default master_application_setting;
