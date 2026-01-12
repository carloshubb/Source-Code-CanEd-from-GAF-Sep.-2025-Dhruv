import ErrorHandling from "../../ErrorHandling";

const demetra_page_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,

            demetra_sport_label: {},
            demetra_sport_placeholder: {},
            demetra_sport_error: {},
            demetra_comunity_service_label: {},
            demetra_comunity_service_placeholder: {},
            demetra_comunity_service_error: {},
            min_cgpa_label: {},
            min_cgpa_placeholder: {},
            min_cgpa_error: {},
            max_cgpa_label: {},
            max_cgpa_placeholder: {},
            max_cgpa_error: {},
            conditional_acceptance_label: {},
            conditional_acceptance_placeholder: {},
            conditional_acceptance_error: {},
        },
        demetra_page_setting: null,
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
        setDemetraPageSetting(state, payload) {
            state.demetra_page_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                demetra_sport_label: {},
                demetra_sport_placeholder: {},
                demetra_sport_error: {},
                demetra_comunity_service_label: {},
                demetra_comunity_service_placeholder: {},
                demetra_comunity_service_error: {},
                min_cgpa_label: {},
                min_cgpa_placeholder: {},
                min_cgpa_error: {},
                max_cgpa_label: {},
                max_cgpa_placeholder: {},
                max_cgpa_error: {},
                conditional_acceptance_label: {},
                conditional_acceptance_placeholder: {},
                conditional_acceptance_error: {},
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
            let url = `${process.env.MIX_ADMIN_API_URL}demetra-page-setting`;
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
                            helper.swalErrorMessage(
                                "you missed required fields please check all language tabs"
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
        fetchDemetraPageSetting({ commit, state }, payload) {
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

export default demetra_page_setting;
