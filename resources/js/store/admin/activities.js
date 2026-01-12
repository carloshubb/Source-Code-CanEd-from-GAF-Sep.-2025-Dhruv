import ErrorHandling from "../../ErrorHandling";
import helper from "../../helper";

const activities = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            type: "",
            name: {},
            status: "",
        },
        activities: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "",
        isFormEdit: false,
        activityTypes: [],
    },
    mutations: {
        setState(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updateState(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] = payload.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setActivities(state, payload) {
            state.activities = payload;
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
            state.param = helper.updateUrlParameter(state.param, "searchParam", payload);
        },
        setLimit(state, payload) {
            state.limit = payload;
            state.param = helper.updateUrlParameter(state.param, "limit", payload);
        },
        setSortBy(state, payload) {
            state.sortBy = payload;
            state.param = helper.updateUrlParameter(state.param, "sortBy", payload);
        },
        setSortType(state, payload) {
            state.sortType = payload;
            state.param = helper.updateUrlParameter(state.param, "sortType", payload);
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                type: "",
                name: {},
                status: "",
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
        },
        setForm(state, payload) {
            state.form.id = payload.id;
            state.form.type = payload.type;
            state.form.status = payload.status;
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
        setActivityTypes(state, payload) {
            state.activityTypes = payload;
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}activities/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}activities`;
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
                            commit("setValidationErros", error.response.data.errors);
                        } else if (error.response && error.response.data && error.response.data.status == "Error") {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchActivities({ commit, state }, payload) {
            let url = payload && payload.url 
                ? payload.url 
                : `${process.env.MIX_ADMIN_API_URL}activities?q=1`;
            
            if (payload && payload.type) {
                url = helper.updateUrlParameter(url, "type", payload.type);
            }
            
            url = `${url}&${state.param}`;
            commit("setLoading");
            
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setActivities", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchActivity({ commit, state }, payload) {
            let url = payload && payload.url
                ? payload.url
                : `${process.env.MIX_ADMIN_API_URL}activities/${payload.id}?q=1&withDetails=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            
                            // Set name values for each language
                            let nameObj = {};
                            if (res.data.data.details) {
                                res.data.data.details.forEach(detail => {
                                    nameObj[`name_${detail.language_id}`] = detail.name;
                                });
                            }
                            commit("setState", { key: "name", value: nameObj });
                            
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteActivity({ commit }, payload) {
            commit("setLoading");
            let url = payload && payload.url
                ? payload.url
                : `${process.env.MIX_ADMIN_API_URL}activities/${payload.id}`;
                
            return axios.delete(url, { data: { password: payload.password } })
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
        fetchActivityTypes({ commit }) {
            return axios.get(`${process.env.MIX_ADMIN_API_URL}activities/types`)
                .then(res => {
                    commit("setActivityTypes", res.data.data);
                    return res;
                });
        },
    },
};

export default activities;