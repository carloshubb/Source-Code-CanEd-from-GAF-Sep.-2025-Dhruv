import ErrorHandling from "../../ErrorHandling";

const school_scholarships = {
    namespaced: true,
    state: {
        errors: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            school_id: "",
            province: "",
            award: "",
            amount: "",
            action: "",
            date_posted: "",
            expiry_date: "",
            deadline_date: "",
            availability: "",
            study_level: "",
            duration: "",
            link: "",
            more_info_link: "",
            featured: "",
            image: "",
            name: {},
            summary: {},
            criteria: {},
            languages: [],
        },
        school_scholarships: null,
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
        updateFormData(state, payload) {
            state.form[payload?.key][
                payload?.key + "_" + payload?.id
            ] = payload?.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setSchoolScholarship(state, payload) {
            const {
                id,
                customer_id,
                province,
                award,
                amount,
                action,
                date_posted,
                expiry_date,
                deadline_date,
                availability,
                study_level,
                duration,
                link,
                more_info_link,
                featured,
                image,
            } = payload;
            state.form["id"] = id;
            state.form["province"] = province;
            state.form["award"] = award;
            state.form["amount"] = amount;
            state.form["action"] = action;
            state.form["date_posted"] = date_posted;
            state.form["expiry_date"] = expiry_date;
            state.form["deadline_date"] = deadline_date;
            state.form["availability"] = availability;
            state.form["study_level"] = study_level;
            state.form["duration"] = duration;
            state.form["link"] = link;
            state.form["more_info_link"] = more_info_link;
            state.form["featured"] = featured;
            state.form["image"] = image;

            for (
                let i = 0;
                i < payload?.school_scholarship_detail?.length;
                i++
            ) {
                if (
                    payload?.school_scholarship_detail[i] &&
                    payload?.school_scholarship_detail[i]?.language_code
                ) {
                    state.form["name"][
                        "name" +
                            "_" +
                            payload?.school_scholarship_detail[i]?.language_code
                    ] = payload?.school_scholarship_detail[i]?.name;
                    state.form["summary"][
                        "summary" +
                            "_" +
                            payload?.school_scholarship_detail[i]?.language_code
                    ] = payload?.school_scholarship_detail[i]?.summary;
                    state.form["criteria"][
                        "criteria" +
                            "_" +
                            payload?.school_scholarship_detail[i]?.language_code
                    ] = payload?.school_scholarship_detail[i]?.criteria;
                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.school_scholarships = payload;
        },
        setSchoolScholarships(state, payload) {
            state.school_scholarships = payload;
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
                province: "",
                award: "",
                amount: "",
                action: "",
                date_posted: "",
                expiry_date: "",
                deadline_date: "",
                availability: "",
                study_level: "",
                duration: "",
                link: "",
                more_info_link: "",
                featured: "",
                image: "",
                name: {},
                summary: {},
                criteria: {},
                languages: [],
            };
            state.errors = new ErrorHandling();
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
                ? `${process.env.MIX_WEB_API_URL}school-scholarships/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school-scholarships`;
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
        fetchSchoolScholarships({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-scholarships?withSchoolScholarshipDetail=1&type=${payload?.type}`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolScholarships", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolScholarship({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-scholarships/${payload.id}?withSchoolScholarshipDetail=1`;
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
        deleteSchoolScholarship({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-scholarships/${payload.id}`;
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

export default school_scholarships;
