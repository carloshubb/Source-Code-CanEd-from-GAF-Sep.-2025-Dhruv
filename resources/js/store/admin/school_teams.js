import ErrorHandling from "../../ErrorHandling";

const school_teams = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            school_id:"",
            name:"",
            designation:"",
            summary:"",
            phone:"",
            email:"",
            image:[],
            languages: [],
        },
        school_teams: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
        showModal: false,
        isDataLoaded: false,
    },
    mutations: {
        removeImage(state, payload) {
            state.form.image.splice(payload, 1);
        },
        setImages(state, payload) {
            state.form.image.push(payload);
        },
        setLanguages(state, payload) {
            state.form.languages = payload;
        },
        setForData(state, payload) {
            if (payload?.language?.id) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.id
                ] = payload?.value;
            } else {
                state.form[payload?.key] = payload?.value;
            }
        },
        updateFormData(state, payload) {
            state.form[payload?.key][payload?.key + "_" + payload?.id] = payload?.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
            state.isDataLoaded = payload;
        },
        setSchoolTeam(state, payload) {
            
            const { id } = payload;
            state.form["id"] = id;
            state.form["name"] = payload?.name;
            state.form["designation"] = payload?.designation;
            state.form["summary"] = payload?.summary;
            state.form["phone"] = payload?.phone;
            state.form["email"] = payload?.email;
            state.isFormEdit = true;
            state.showModal = true;

            if (payload.image) {
                for (
                    var i = 0;
                    i < payload.images?.length;
                    i++
                ) {
                    state.form.image.push(payload.images[i]);
                }
            }

            // state.school_teams = payload;
        },
        setSchoolTeams(state, payload) {
            state.school_teams = payload;
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
                customer_id:"",
                school_id:"",
                image:[],
                title: {},
                short_description: {},
                detail_description: {},
                category_name: {},
                languages: [],
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
            let method = "post";
            let url = `${process.env.MIX_WEB_API_URL}school-teams`;
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
        fetchSchoolTeams({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    :  `${process.env.MIX_WEB_API_URL}school-teams?withBlogDetail=1&school_id=${payload?.school_id}`;

            url = `${url}&school_id=${payload?.school_id}`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolTeams", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolTeam({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-teams/${payload.id}?withBlogDetail=1`;
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
        deleteSchoolTeam({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-teams/${payload.id}`;
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

export default school_teams;
