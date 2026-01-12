import ErrorHandling from "../../ErrorHandling";

const master_applications = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            first_name: "",
            last_name: "",
            email: "",
            confirm_email: "",
            dob: "",
            gender: "",
            phone: "",
            can_school_text_you: "",
            for_demetra_or_master_app: "",
            messaging_app: "",
            messaging_app_username: "",
            where_want_to_study: "",
            country_of_citizenship: "",
            live_in_your_country_citizenship: "",
            current_residance: "",
            current_residance_status: "",
            mailing_address: "",
            high_school_name: "",
            statement_of_purpose: "",
            letter_of_intent: "",
            high_school_cgpa: "",
            high_school_city: "",
            high_school_country: "",
            when_plan_to_start: "",
            interested_in: "",
            would_like_to_study: "",
            student_type: "",
            tuition_funding_source: "",
            test_taken: "",
            addtional: "",
            add_anything: "",
            currently_living_in_canada: "",
            currently_student_anywhere: "",
            study_permit_candian_embassy: "",
            send_me_a_copy: "",
            school_id: "",
            customer_id: "",
        },
        master_applications: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
    },
    mutations: {
        setState(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateState(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setmaster_applications(state, payload) {
            state.master_applications = payload;
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
        resetForm(state) {
            state.form = {
                id: null,
                first_name: "",
                last_name: "",
                email: "",
                confirm_email: "",
                dob: "",
                gender: "",
                phone: "",
                can_school_text_you: "",
                messaging_app: "",
                messaging_app_username: "",
                where_want_to_study: "",
                country_of_citizenship: "",
                live_in_your_country_citizenship: "",
                current_residance: "",
                current_residance_status: "",
                mailing_address: "",
                high_school_name: "",
                for_demetra_or_master_app: "",
                high_school_cgpa: "",
                statement_of_purpose: "",
                letter_of_intent: "",
                high_school_city: "",
                high_school_country: "",
                when_plan_to_start: "",
                interested_in: "",
                would_like_to_study: "",
                student_type: "",
                tuition_funding_source: "",
                test_taken: "",
                addtional: "",
                add_anything: "",
                currently_living_in_canada: "",
                currently_student_anywhere: "",
                study_permit_candian_embassy: "",
                send_me_a_copy: "",
                school_id: "",
                customer_id: "",
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
        },
        setUrl(state, payload) {
            state.form.url = payload;
        },
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
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}master_applications/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}master_applications`;
            commit("setLoading");
             
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            commit("resetForm");
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
        fetchMasterApplications({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}master_applications?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setmaster_applications", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchMasterApplicationsBySchool({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}master_applications?school=`+payload;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setmaster_applications", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        
        fetchMasterApplication({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}master_applications/${payload.id}?q=1`;
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
        deleteMasterApplication({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}master_applications/${payload.id}`;
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

export default master_applications;
