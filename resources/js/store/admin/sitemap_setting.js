import ErrorHandling from "../../ErrorHandling";

const sitemap_setting = {
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
        },
        sitemap_setting: null,
        loading: false,
        limit: 10,
        section_1_menus: [],
        section_2_menus: [],
        section_3_menus: [],
        section_4_menus: [],
    },
    mutations: {
        addSection1Menus(state, payload) {
            state.section_1_menus.push(1);
        },
        setPageSetting(state, payload) {
            //  
            state.form[payload.key] = payload.value;
        },
        updatePageSetting(state, payload) {
            state.form[payload.key][`${payload.key}_${payload.id}`] =
                payload.value;
        },
        setSitemapSetting(state, payload) {
            state.sitemap_setting = payload;
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
                menu1: [],
                menu2: [],
                menu3: [],
                menu4: [],
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
        addUpdateForm({ commit, state }, payload) {
            let url = `${process.env.MIX_ADMIN_API_URL}sitemap-setting`;
            commit("setPageSetting", { key: "menu1", value: payload?.menu1 });
            commit("setPageSetting", { key: "menu2", value: payload?.menu2 });
            commit("setPageSetting", { key: "menu3", value: payload?.menu3 });
            commit("setPageSetting", { key: "menu4", value: payload?.menu4 });

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
                            helper.swalErrorMessage(
                                "you missed required fields please check all language tabs"
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
        fetchSitemapSetting({ commit, state }, payload) {
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

export default sitemap_setting;
