import ErrorHandling from "../../ErrorHandling";

const open_days = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            address: "",
            city: "",
            country: "",
            date: "",
            school_phone: "",
            school_email: "",
            postal_code: "",
            open_day_url: "",
            image: "",
            customer_id: "",
            school_id: "",
            title: {},
            description: {},
            languages: [],
        },
        open_days: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
        showModal: false,
    },
    mutations: {
        setLanguages(state, payload) {
            state.form.languages = payload;
        },
        setForData(state, payload) {
            if (payload?.language?.language_code) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.language_code
                ] = payload?.value;
            } else {
                state.form[payload?.key] = payload?.value;
            }
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setOpenDay(state, payload) {
            state.form[payload?.key] = payload?.value;
            // const { id, address, city } = payload;
            // state.form["id"] = id;
            // state.form["address"] = address;
            // state.form["city"] = city;
            // state.form["country"] = country;
            // state.form["date"] = date;
            // state.form["time"] = time;
            // state.form["school_email"] = school_email;
            // state.form["school_phone"] = school_phone;
            // state.form["open_day_url"] = open_day_url;
            // state.form["image"] = image;

            // for (let i = 0; i < payload?.open_day_detail?.length; i++) {
            //     if (
            //         payload?.open_day_detail[i] &&
            //         payload?.open_day_detail[i]?.language_code
            //     ) {
            //         state.form["answer"][
            //             "title" +
            //                 "_" +
            //                 payload?.open_day_detail[i]?.language_code
            //         ] = payload?.open_day_detail[i]?.title;
            //         state.form["question"][
            //             "description" +
            //                 "_" +
            //                 payload?.open_day_detail[i]?.language_code
            //         ] = payload?.open_day_detail[i]?.description;
            //     }
            // }
            // state.isFormEdit = true;
            // state.showModal = true;

            // state.open_days = payload;
        },
        setOpenDays(state, payload) {
            state.open_days = payload;
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
                address: "",
                city: "",
                country: "",
                date: "",
                school_phone: "",
                school_email: "",
                open_day_url: "",
                postal_code: "",
                image: "",
                customer_id: "",
                school_id: "",
                title: {},
                description: {},
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
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_WEB_API_URL}open-days/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}open-days`;
            commit("setLoading");
             
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessage(res.data.message);
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
        fetchOpenDays({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}open-days?withOpenDayDetail=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setOpenDays", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchOpenDay({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}open-days/${payload.id}?withOpenDayDetail=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setOpenDay", {
                                key: "city",
                                value: res.data.data.city,
                            });

                            commit("setOpenDay", {
                                key: "country",
                                value: res.data.data.country,
                            });

                            commit("setOpenDay", {
                                key: "address",
                                value: res.data.data.address,
                            });

                            commit("setOpenDay", {
                                key: "open_day_url",
                                value: res.data.data.open_day_url,
                            });
                            commit("setOpenDay", {
                                key: "postal_code",
                                value: res.data.data.postal_code,
                            });
                            commit("setOpenDay", {
                                key: "image",
                                value: res.data.data.image,
                            });
                            commit("setOpenDay", {
                                key: "school_email",
                                value: res.data.data.school_email,
                            });
                            commit("setOpenDay", {
                                key: "school_phone",
                                value: res.data.data.school_phone,
                            });

                            commit("setOpenDay", {
                                key: "date",
                                value: res.data.data.date,
                            });
                            commit("setOpenDay", {
                                key: "time",
                                value: res.data.data.time,
                            });
                            let title = {};
                            let description = {};
                            for (
                                var i = 0;
                                i < res.data.data.open_day_detail?.length;
                                i++
                            ) {
                                title[
                                    "title_" +
                                        res.data.data.open_day_detail[i]
                                            ?.language_code
                                ] = res.data.data.open_day_detail[i]?.title;

                                description[
                                    "description_" +
                                        res.data.data.open_day_detail[i]
                                            ?.language_code
                                ] =
                                    res.data.data.open_day_detail[
                                        i
                                    ]?.description;
                            }
                            commit("setOpenDay", {
                                key: "title",
                                value: title,
                            });

                            commit("setOpenDay", {
                                key: "description",
                                value: description,
                            });
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteOpenDay({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}open-days/${payload.id}`;
            return new Promise(function (resolve, reject) {
                axios
                    .delete(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessage(res.data.message);
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

export default open_days;
