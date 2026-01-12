import ErrorHandling from "../../ErrorHandling";

const school_programs = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            school_id: "",
            degree_id: "",
            program_id: "",
            description: {},
            name: {},
            languages: [],
            already_existed:false,
        },
        school_programs: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
        showModal: false,
    },
    mutations: {
        setDegree(state, payload) {
            state.form.degree_id = payload;
        },
        setLanguages(state, payload) {
            state.form.languages = payload;
        },
        setForData(state, payload) {
            if (payload?.language?.language_code) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.language_code
                ] = payload?.value;
            } else {
                state.form[payload?.key] = payload?.value;
            }
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setSchoolProgram(state, payload) {
            const { id, program_id, degree_id } = payload;
            state.form["id"] = id;
            state.form["program_id"] = program_id;
            state.form["degree_id"] = degree_id;

            for (let i = 0; i < payload?.school_program_detail?.length; i++) {
                if (
                    payload?.school_program_detail[i] &&
                    payload?.school_program_detail[i]?.language_code
                ) {
                    state.form["description"][
                        "description" +
                            "_" +
                            payload?.school_program_detail[i]?.language_code
                    ] = payload?.school_program_detail[i]?.description;
                }
            }
            for (let i = 0; i < payload?.program?.program_detail?.length; i++) {
                if (
                    payload?.program?.program_detail[i] &&
                    payload?.program?.program_detail[i]?.abbreviation
                ) {
                     (payload?.program?.program_detail[i]?.name,"");
                    state.form["name"][
                        "name" +
                            "_" +
                            payload?.program?.program_detail[i]?.abbreviation
                    ] = payload?.program?.program_detail[i]?.name;
                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.school_programs = payload;
        },
        setSchoolPrograms(state, payload) {
            state.school_programs = payload;
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
                school_id: "",
                degree_id: "",
                program_id: "",
                description: {},
                name: {},
                languages: [],
                already_existed:false,
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
            state.showModal = false;
        },
        setUrl(state, payload) {
            state.form.url = payload;
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
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_WEB_API_URL}school-programs/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school-programs`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
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
        fetchSchoolPrograms({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-programs?withSchoolProgramDetail=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolPrograms", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolProgram({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-programs/${payload.id}?withSchoolProgramDetail=1`;
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
        deleteSchoolProgram({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-programs/${payload.id}`;
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

export default school_programs;
