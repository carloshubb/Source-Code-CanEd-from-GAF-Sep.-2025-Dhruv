import ErrorHandling from "../../ErrorHandling";

const footer_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            section_1_title: {},
            section_2_title: {},
            section_3_title: {},
            section_4_title: {},
            copy_right_text: {},
            facebook_icon: "",
            twitter_icon: "",
            insta_icon: "",
            linkedin_icon: "",
            youtube_icon: "",
            facebook_url: "",
            twitter_url: "",
            insta_url: "",
            linkedin_url: "",
            youtube_url: "",
            menu1: "",
            menu2: "",
            menu3: "",
            menu4: "",
        },
        footer_setting: null,
        loading: false,
        limit: 10,
    },
    mutations: {
        setPageSetting(state, payload) {
            //  
            state.form[payload.key] = payload.value;
        },
        updatePageSetting(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },
        setFooterSetting(state, payload) {
            state.footer_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                section_1_title: {},
                section_2_title: {},
                section_3_title: {},
                section_4_title: {},
                copy_right_text: {},
                facebook_icon: "",
                twitter_icon: "",
                insta_icon: "",
                linkedin_icon: "",
                youtube_icon: "",
                facebook_url: "",
                twitter_url: "",
                insta_url: "",
                linkedin_url: "",
                youtube_url: "",
                menu1: "",
                menu2: "",
                menu3: "",
                menu4: "",
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
            let url = `${process.env.MIX_ADMIN_API_URL}footer-setting`;
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
        fetchFooterSetting({ commit, state }, payload) {
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

export default footer_setting;
