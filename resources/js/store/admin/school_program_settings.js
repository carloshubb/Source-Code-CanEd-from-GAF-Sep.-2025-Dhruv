import ErrorHandling from "../../ErrorHandling";

const school_program_settings = {
    namespaced: true,
    state: {
        errors: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            school_program_apply_button_link: "",
            school_program_apply_button_title: "",
            school_program_blue_bar_button_title: "",
            school_program_blue_bar_button_link: "",
            school_program_red_bar_button_link: "",
            school_program_red_bar_button_title: "",
            school_id:"",
            title_1: {},
            title_1_paragraph: {},
        },
        languages: [],
        school_program_settings: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
        showModal: false,
        is_featured_array: [],
    },
    mutations: {
        setIsFeatured(state, payload) {
            if (payload.checked) {
                state.is_featured_array.push(payload.key);
            } else {
                var index = state.is_featured_array.indexOf(payload.key);
                state.is_featured_array.splice(index, 1);
            }
            state.form.marked_facts = state.is_featured_array.toString();
        },
        setIsFeaturedArray(state, payload) {
            state.is_featured_array = payload;
        },
        setLanguages(state, payload) {
            state.languages = payload;
        },
        setForData(state, payload) {
            if (payload?.language?.abbreviation) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.abbreviation
                ] = payload?.value;
            } else {
                state.form[payload?.key] = payload?.value;
            }
        },
        updateFormData(state, payload) {
            state.form[payload?.key][
                payload?.key + "_" + payload?.id
            ] = payload?.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setSchoolProgramSetting(state, payload) {
            for (let i = 0; i < payload?.school_overview_detail?.length; i++) {
                if (
                    payload?.school_overview_detail[i] &&
                    payload?.school_overview_detail[i]?.language_code
                ) {
                    
                    state.form["title_1_paragraph"][
                        "title_1_paragraph" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.title_1_paragraph;
                    state.form["title_1"][
                        "title_1" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.title_1;
                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.school_program_settings = payload;
        },
        setSchoolProgramSettings(state, payload) {
            state.school_program_settings = payload;
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
                customer_id: "",
                school_program_blue_bar_button_title: "",
                school_program_blue_bar_button_link: "",
                school_program_red_bar_button_link: "",
                school_program_red_bar_button_title: "",
                school_program_apply_button_link: "",
                school_program_apply_button_title: "",
                title_1: {},
            };
            state.errors = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
            state.showModal = false;
            is_featured_array = [];
        },
        setUrl(state, payload) {
            state.form.url = payload;
        },
        setForm(state, payload) {
            state.form.id = payload.id;
        },
        setValidationErros(state, payload) {
            state.errors.record(payload);
        },
        setEmptyError(state) {
            state.errors = new ErrorHandling();
        },
        setError(state, payload) {
            state.error = payload;
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_WEB_API_URL}school-program-settings/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school-program-settings`;
            commit("setLoading");

            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            // commit("resetForm");
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
        fetchSchoolProgramSettings({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-program-settings?withSchoolProgramSettingDetail=1&type=${payload?.type}`;
            url = `${url}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolProgramSettings", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolProgramSetting({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-program-settings/${payload.id}?withSchoolProgramSettingDetail=1`;
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
        deleteSchoolProgramSetting({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-program-settings/${payload.id}`;
            return new Promise(function (resolve, reject) {
                axios
                    .delete(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else if (res.data.status == "Error") {
                            helper.swalErrorMessage(res.data.message);
                            resolve(res);
                        }
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    },
};

export default school_program_settings;
