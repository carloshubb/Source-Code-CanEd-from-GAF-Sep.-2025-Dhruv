import ErrorHandling from "../../ErrorHandling";

const businesses = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            title: {},
            name: {},
            customer_id: "",
            registration_package_id: "",
            facebook_url: "",
            welcome_video: "",
            twitter_url: "",
            logo: "",
            youtube_url: "",
            linked_url: "",
            other_social_url: "",
            keywords: "",
            image: [],
            contact_name: "",
            email: "",
            phone: "",
            address: "",
            website_url: "",
            business_catagory_1: "",
            business_catagory_2: "",
            business_catagory_3: "",
            business_name: {},
            description: {},
            detail_description: {},
            media_section_title: {},
            media_section_description: {},
        },
        businesses: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withBusinessDetail=1",
        isFormEdit: false,
    },
    mutations: {
        removeImage(state, payload) {
            state.form.image.splice(payload, 1);
        },
        setImages(state, payload) {
            state.form.image.push(payload);
        },
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
        setBusinesses(state, payload) {
            state.businesses = payload;
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
                customer_id: "",
                registration_package_id: "",
                facebook_url: "",
                welcome_video: "",
                twitter_url: "",
                logo: "",
                youtube_url: "",
                linked_url: "",
                other_social_url: "",
                keywords: "",
                image: [],
                contact_name: "",
                email: "",
                phone: "",
                address: "",
                website_url: "",
                business_catagory_1: "",
                business_catagory_2: "",
                business_catagory_3: "",
                business_name: {},
                description: {},
                detail_description: {},
                media_section_title: {},
                media_section_description: {},
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
            // state.form.image = payload.image;
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
                ? `${process.env.MIX_ADMIN_API_URL}businesses/${state.form.id}`
                : `${process.env.MIX_ADMIN_API_URL}businesses`;
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
        fetchBusinesses({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}businesses?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setBusinesses", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchBusiness({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}businesses/${payload.id}?q=1`;
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
        deleteBusiness({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}businesses/${payload.id}`;
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
        deactiveBusiness({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_ADMIN_API_URL}businesses/deactive-business`;
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

export default businesses;
