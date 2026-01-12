import ErrorHandling from "../../ErrorHandling";

const home_page_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            banner_1: "",
            banner_2: "",
            banner_3: "",
            welcome_title: {},
            welcome_description: {},
            welcome_button_text: {},
            welcome_button_link: {},
            welcome_image: {},
            featured_title: {},
            featured_description: {},
            featured_business_title: {},
            featured_business_description: {},
            article_section_1_title: {},
            article_section_1_description: {},
            article_section_2_title: {},
            article_section_2_description: {},
            article_section_3_title: {},
            article_section_3_description: {},
            recent_article_title: {},
            recent_article_description: {},
            article_card_title: {},
            video_card_title: {},
            recent_article_image: {},
            recent_video_image: {},
        },
        home_page_setting: null,
        loading: false,
        limit: 10,
    },
    mutations: {
        setPageSetting(state, payload) {
            state.form[payload.key] = payload.value;
        },
        updatePageSetting(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },
        setHomePageSetting(state, payload) {
            state.home_page_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        setBanner(state,payload){
            state.form[payload.key] = payload.value;
        },
        resetForm(state) {
            state.form = {
                id: null,
                banner_1: "",
                banner_2: "",
                banner_3: "",
                welcome_title: {},
                welcome_description: {},
                welcome_button_text: {},
                welcome_button_link: {},
                welcome_image: {},
                featured_title: {},
                featured_description: {},
                featured_business_title: {},
                featured_business_description: {},
                article_section_1_title: {},
                article_section_1_description: {},
                article_section_2_title: {},
                article_section_2_description: {},
                article_section_3_title: {},
                article_section_3_description: {},
                recent_article_title: {},
                recent_article_description: {},
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
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
            let url = `${process.env.MIX_ADMIN_API_URL}home-page-setting`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .post(url, state.form)
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
                            helper.swalErrorMessage("you missed required fields please check all language tabs");
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
        fetchHomePageSetting({ commit, state }, payload) {
            let url = payload.url;
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
    },
};

export default home_page_setting;
