import ErrorHandling from "../../ErrorHandling";

const open_days = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            address: "",
            city: "",
            country: "",
            date: "",
            time: "",
            school_email: "",
            school_phone: "",
            open_day_url: "",
            postal_code: "",
            image: "",
            title:"",
            description:"",
        },
        open_days: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "",
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
        setSchoolScholarships(state, payload) {
            state.open_days = payload;
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
                address: "",
                city: "",
                country: "",
                date: "",
                time: "",
                school_email: "",
                school_phone: "",
                open_day_url: "",
                postal_code: "",
                image: "",
                title: "",
                description:"",
                school_name:"",
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
            state.form.title = payload.OpenDayDetail ? payload.OpenDayDetail[0].title : '';
            state.form.description = payload.OpenDayDetail ? payload.OpenDayDetail[0].description : '';
            state.form.school_name = payload.school.school_detail ? payload.school.school_detail[0].school_name : '';
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
        setOpenDayDetailTitle(state, title) {
            state.title = title; 
        },
        
        setOpenDayDetailDescription(state, description) {
            state.description = description; 
        }, 
        setOpenDaySchoolName(state, payload) { 
            state.payload = payload; 
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}open_days/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}open_days`;
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
        fetchOpenDays({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}open_days?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolScholarships", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchOpenDay({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}open_days/${payload.id}?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            if (res.data.data.OpenDayDetail) { 
                                commit("setOpenDayDetailTitle", res.data.data.OpenDayDetail[0].title); 
                            }
                             if (res.data.data.OpenDayDetail) { 
                                commit("setOpenDayDetailDescription", res.data.data.OpenDayDetail[0].description); 
                            }
                            if (res.data.data.school.school_detail) { 
                                commit("setOpenDaySchoolName", res.data.data.school.school_detail[0].school_name); 
                            }
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteOpenDay({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}open_days/${payload.id}`;
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
        deactiveOpenDay({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}open_days/deactive-school`;
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, payload)
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

export default open_days;
