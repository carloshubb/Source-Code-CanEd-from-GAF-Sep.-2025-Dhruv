import ErrorHandling from "../../ErrorHandling";

const school_overviews = {
    namespaced: true,
    state: {
        errors: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            school_overviews_apply_button_link: "",
            school_overviews_apply_button_title: "",
            school_overviews_blue_bar_button_title: "",
            school_overviews_blue_bar_button_link: "",
            school_overviews_red_bar_button_title: "",
            school_overviews_red_bar_button_link: "",
            display_blog: false,
            number_of_blog_posts: null,
            video_url: null,
            blog_posts_order: null,
            blog_pre_description: {},
            blog_post_description: {},
            programs_pre_description: {},
            programs_post_description: {},
        },
        languages: [],
        school_overviews: null,
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
            state.form[payload?.key][payload?.key + "_" + payload?.id] = payload?.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setSchoolOverview(state, payload) {
            state.form["display_blog"] = payload.display_blog;
            state.form["number_of_blog_posts"] = payload.number_of_blog_posts;
            state.form["video_url"] = payload.video_url;
            state.form["blog_posts_order"] = payload.blog_posts_order;

            for (let i = 0; i < payload?.school_overview_detail?.length; i++) {
                if (
                    payload?.school_overview_detail[i] &&
                    payload?.school_overview_detail[i]?.language_code
                ) {
                    state.form["blog_pre_description"]["blog_pre_description" + "_" + payload?.school_overview_detail[i]?.language_code] = payload?.school_overview_detail[i]?.blog_pre_description;

                    state.form["blog_post_description"]["blog_post_description" + "_" + payload?.school_overview_detail[i]?.language_code] = payload?.school_overview_detail[i]?.blog_post_description;

                    state.form["programs_pre_description"]["programs_pre_description" + "_" + payload?.school_overview_detail[i]?.language_code] = payload?.school_overview_detail[i]?.programs_pre_description;

                    state.form["programs_post_description"]["programs_post_description" + "_" + payload?.school_overview_detail[i]?.language_code] = payload?.school_overview_detail[i]?.programs_post_description;
                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.school_overviews = payload;
        },
        setSchoolOverviews(state, payload) {
            state.school_overviews = payload;
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
                title_3_image: "",
                title_3_date: "",
                school_overviews_blue_bar_button_title: "",
                school_overviews_blue_bar_button_link: "",
                school_overviews_red_bar_button_title: "",
                school_overviews_red_bar_button_link: "",
                school_overviews_apply_button_link: "",
                school_overviews_apply_button_title: "",
                title_4_image: "",
                title_3_button_link: "",
                title_6_button_link: "",
                title_8_button_link: "",
                title_9_image: "",
                title_9_button_link: "",
                title_1: {},
                title_1_paragraph: {},
                title_1_content: {},
                title_2: {},
                title_2_bullet_points: {},
                title_3_subtitle: {},
                title_3_paragraph: {},
                title_3_button_title: {},
                title_3_image_name: {},
                title_4: {},
                title_4_paragraph: {},
                title_5: {},
                title_5_paragraph: {},
                title_6: {},
                title_6_paragraph: {},
                title_6_button_title: {},
                title_7: {},
                title_7_paragraph: {},
                title_7_button_title: {},
                title_8: {},
                title_8_paragraph: {},
                title_9: {},
                title_9_subtitle: {},
                title_9_paragraph: {},
                title_9_button_title: {},
                title_9_image_name: {},
                title_10: {},
                title_10_paragraph: {},
                title_11: {},
                title_11_paragraph: {},
                title_12: {},
                title_12_bullet_points: {},
                title_13: {},
                title_13_paragraph: {},
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
                ? `${process.env.MIX_WEB_API_URL}school-overviews/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school-overviews`;
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
        fetchSchoolOverviews({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-overviews?withSchoolOverviewDetail=1&type=${payload?.type}`;
            url = `${url}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolOverviews", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolOverview({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-overviews/${payload.id}?withSchoolOverviewDetail=1`;
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
        deleteSchoolOverview({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-overviews/${payload.id}`;
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

export default school_overviews;
