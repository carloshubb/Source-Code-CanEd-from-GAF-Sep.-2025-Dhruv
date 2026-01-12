import ErrorHandling from "../../ErrorHandling";

const articles = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            name: {},
            short_description: {},
            description: {},
            article_image: "",
            article_category_id: "",
            original_source: "",
            name_title: "",
            organization: "",
            website: "",
            keyword: "",
            type: "",
        },
        articles: null,
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
        setType(state,payload){
            state.form.type = payload;
            console.log('state.form.type = payload',state.form.type = payload);
        },
        setName(state, payload) {
            state.form.name = payload;
            console.log('state.name.name = payload',state.form.name = payload);
        },
        setShortDescription(state, payload) {
            state.form.short_description = payload;
        },
        setDescription(state, payload) {
            state.form.description = payload;
        },
        updateShortDescription(state, payload) {
            state.form.short_description[`short_description_${payload.id}`] =
                payload.short_description;
        },
        updateDescription(state, payload) {
            state.form.description[`description_${payload.id}`] =
                payload.description;
        },
        updateName(state, payload) {
            state.form.name[`name_${payload.id}`] = payload.name;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setArticleCategories(state, payload) {
            state.articles = payload;
        },
        // setPagination(state, pagination) {
        //     if (pagination.meta) {
        //         state.pagination = {
        //             current_page: pagination.meta.current_page,
        //             last_page: pagination.meta.last_page,
        //             next_page_url: pagination.links
        //                 ? pagination.links.next
        //                 : null,
        //             prev_page_url: pagination.links
        //                 ? pagination.links.prev
        //                 : null,
        //         };
        //     }
        // },
        setPagination(state, pagination) {
            if (pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page,
                    last_page: pagination.meta.last_page,
                    next_page_url: pagination.links ? pagination.links.next : null,
                    prev_page_url: pagination.links ? pagination.links.prev : null,
                    base_url: pagination.meta.path, // Base API path
                    first_page_url: pagination.links.first, // First page URL
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
                name: {},
                short_description: {},
                description: {},
                article_image: "",
                article_category_id: "",
                original_source: "",
                name_title: "",
                organization: "",
                website: "",
                keyword: "",
                type: "",
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
        },
        setForm(state, payload) {
            state.form[payload?.key] = payload?.value;
        },
        setOriginalSource(state, payload) {
            state.form.original_source = payload;
        },
        setNameTitle(state, payload) {
            state.form.name_title = payload;
        },
        setOrganization(state, payload) {
            state.form.organization = payload;
        },
        setKeyword(state, payload) {
            state.form.keyword = payload;
        },
        setWebsite(state, payload) {
            state.form.website = payload;
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
            console.log(state.form.id,'state');
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_ADMIN_API_URL}articles/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}articles`;
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
        fetchArticles({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}articles?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        console.log('state articles res',res);
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setArticleCategories", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchArticleCategorie({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}articles/${payload.id}?q=1`;
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
        deleteArticle({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}articles/${payload.id}`;
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

export default articles;
