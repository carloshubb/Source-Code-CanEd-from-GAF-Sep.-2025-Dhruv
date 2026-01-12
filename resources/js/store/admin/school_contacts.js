import ErrorHandling from "../../ErrorHandling";

const school_contacts = {
    namespaced: true,
    state: {
        errors: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            school_id: "",
            department: "",
            address: "",
            direct_email: "",
            contact_linkedin: "",
            contact_instagram: "",
            contact_facebook: "",
            city: "",
            country: "",
            phone: "",
            fax: "",
            website_link: "",
            order: "",
            image: "",
            name: {},
            brief_descr: {},
            languages: [],
        },
        school_contacts: null,
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
            if (payload?.language?.abbreviation) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.abbreviation
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
        setSchoolContact(state, payload) {
            const {
                id,
                customer_id,
                department,
                address,
                direct_email,
                contact_facebook,
                contact_instagram,
                contact_linkedin,
                city,
                country,
                phone,
                fax,
                website_link,
                order,
                image,
            } = payload;
            state.form["id"] = id;
            state.form["order"] = order;
            state.form["customer_id"] = customer_id;
            state.form["department"] = department;
            state.form["address"] = address;
            state.form["contact_facebook"] = contact_facebook;
            state.form["contact_instagram"] = contact_instagram;
            state.form["contact_linkedin"] = contact_linkedin;
            state.form["direct_email"] = direct_email;
            state.form["city"] = city;
            state.form["country"] = country;
            state.form["phone"] = phone;
            state.form["fax"] = fax;
            state.form["website_link"] = website_link;
            state.form["image"] = image;

            for (let i = 0; i < payload?.school_contact_detail?.length; i++) {
                if (
                    payload?.school_contact_detail[i] &&
                    payload?.school_contact_detail[i]?.language_code
                ) {
                    state.form["name"][
                        "name" +
                            "_" +
                            payload?.school_contact_detail[i]?.language_code
                    ] = payload?.school_contact_detail[i]?.name;
                    state.form["brief_descr"][
                        "brief_descr_" + payload?.school_contact_detail[i]?.language_code
                    ] = payload?.school_contact_detail[i]?.brief_descr;
                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.school_contacts = payload;
        },
        setSchoolContacts(state, payload) {
            state.school_contacts = payload;
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
                department: "",
                address: "",
                contact_linkedin: "",
                contact_instagram: "",
                contact_facebook: "",
                direct_email: "",
                city: "",
                country: "",
                phone: "",
                fax: "",
                website_link: "",
                order: "",
                image: "",
                name: {},
                brief_descr: {},
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
                ? `${process.env.MIX_WEB_API_URL}school-contacts/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school-contacts`;
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
        fetchSchoolContacts({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-contacts?withSchoolContactDetail=1&is_admin=1&school_id=${payload?.school_id}`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolContacts", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolContact({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-contacts/${payload.id}?withSchoolContactDetail=1`;
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
        deleteSchoolContact({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-contacts/${payload.id}`;
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

export default school_contacts;
