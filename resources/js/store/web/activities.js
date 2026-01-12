import ErrorHandling from "../../ErrorHandling";

const activities = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
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
        activityTypes: {
            'curricular': 'Curricular Activities',
            'extracurricular': 'Extracurricular Activities',
            'leadership': 'Leadership',
            'media': 'Media',
            'music_performance': 'Music & Performance',
            'social_activism': 'Social Activism',
            'technology': 'Technology',
            'entrepreneurship': 'Entrepreneurship',
            'environmental': 'Environmental & Sustainability',
            'health_wellness': 'Health & Wellness',
            'stem_competitions': 'STEM competitions'
        }
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
                name: {},
                status: "",
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
        },
        setForm(state, payload) {
            state.form.id = payload.id;
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
    },
    actions: {
        fetchActivities({ commit, state }, payload) {
            let url = payload && payload.url 
                ? payload.url 
                : `${process.env.MIX_WEB_API_URL}activities?q=1`;
            
            if (payload && payload.type) {
                url = helper.updateUrlParameter(url, "type", payload.type);
            }
            
            url = `${url}&${state.param}`;
            commit("setLoading");
            
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        console.log('staete extra res',res);
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
        saveDefaultLanguageActivity({ commit }, payload) {
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(`${process.env.MIX_WEB_API_URL}save-activity`, payload)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        } else {
                            reject(res);
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
                : `${process.env.MIX_WEB_API_URL}activities/${payload.id}`;
                
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
    },
};

export default activities;