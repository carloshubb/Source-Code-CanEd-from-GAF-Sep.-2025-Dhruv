import ErrorHandling from "../../ErrorHandling";

const blogs = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            school_id:"",
            image:[],
            title: {},
            short_description: {},
            detail_description: {},
            category_name: {},
            languages: [],
        },
        blogs: null,
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
        setBlog(state, payload) {
            
            const { id } = payload;
            state.form["id"] = id;

            for (let i = 0; i < payload?.blog_detail?.length; i++) {
                if (
                    payload?.blog_detail[i] &&
                    payload?.blog_detail[i]?.language_id
                ) {
                    state.form["short_description"][
                        "short_description" + "_" + payload?.blog_detail[i]?.language_id
                    ] = payload?.blog_detail[i]?.short_description;
                    state.form["detail_description"][
                        "detail_description" + "_" + payload?.blog_detail[i]?.language_id
                    ] = payload?.blog_detail[i]?.detail_description;
                    state.form["category_name"][
                        "category_name" + "_" + payload?.blog_detail[i]?.language_id
                    ] = payload?.blog_detail[i]?.category_name;
                    state.form["title"][
                        "title" + "_" + payload?.blog_detail[i]?.language_id
                    ] = payload?.blog_detail[i]?.title;
                }
            }
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

            // state.blogs = payload;
        },
        setBlogs(state, payload) {
            state.blogs = payload;
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
            let url = `${process.env.MIX_WEB_API_URL}blogs`;
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
        fetchBlogs({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    :  `${process.env.MIX_WEB_API_URL}blogs?withBlogDetail=1&school_id=${payload?.school_id}`;

            url = `${url}&school_id=${payload?.school_id}`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setBlogs", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchBlog({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}blogs/${payload.id}?withBlogDetail=1`;
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
        deleteBlog({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}blogs/${payload.id}`;
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

export default blogs;
