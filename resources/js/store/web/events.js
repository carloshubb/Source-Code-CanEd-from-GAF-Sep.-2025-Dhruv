import ErrorHandling from "../../ErrorHandling";

const events = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            is_web: 1,
            start_date: "",
            location: "",
            end_date: "",
            event_website: "",
            exibiters_url: "",
            visitor_url: "",
            press_url: "",
            video_url: "",
            facebook_url: "",
            instagram_url: "",
            linkedin_url: "",
            youtube_url: "",
            pintrest_url: "",
            snapchat_url: "",
            twitter_url: "",
            featured_image: "",
            status: "",
            state_province: "",
            city: "",
            customer_id: "",
            school_id: "",
            country: "",
            street_name: "",
            veneue: "",
            product_search: "",
            title: {},
            description: {},
            short_description: {},
            images: [],
            contacts: [
                {
                    contact_name: "",
                    contact_email: "",
                    contact_phone: "",
                    contact_title: "",
                },
            ],
            contact_name: [],
            contact_email: [],
            contact_phone: [],
            contact_title: [],
        },
        events: null,
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
        setContacts(state, payload) {
            const { index, key, value } = payload;
            state.form.contacts[index][key] = value;
        },
        addToContacts(state, payload) {
            state?.form?.contacts?.push({
                contact_name: "",
                contact_email: "",
                contact_phone: "",
                contact_title: "",
            });
            state?.form?.contact_name.push("");
            state?.form?.contact_email.push("");
            state?.form?.contact_phone.push("");
            state?.form?.contact_title.push("");
        },
        removeFromContacts(state, payload) {
            state.form.contacts.splice(payload, 1);
            state?.form?.contact_name.splice(payload, 1);
            state?.form?.contact_email.splice(payload, 1);
            state?.form?.contact_phone.splice(payload, 1);
            state?.form?.contact_title.splice(payload, 1);
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
        setEvents(state, payload) {
            state.events = payload;
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
                start_date: "",
                location: "",
                is_web: 1,
                end_date: "",
                event_website: "",
                exibiters_url: "",
                visitor_url: "",
                press_url: "",
                video_url: "",
                facebook_url: "",
                instagram_url: "",
                linkedin_url: "",
                youtube_url: "",
                customer_id: "",
                school_id: "",
                pintrest_url: "",
                snapchat_url: "",
                twitter_url: "",
                featured_image: "",
                status: "",
                state_province: "",
                city: "",
                country: "",
                street_name: "",
                veneue: "",
                product_search: "",
                repost_event: false,
                title: {},
                description: {},
                short_description: {},
                images: [],
                contacts: [
                    {
                        contact_name: "",
                        contact_email: "",
                        contact_phone: "",
                        contact_title: "",
                    },
                ],
                contact_name: [],
                contact_email: [],
                contact_phone: [],
                contact_title: [],
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
        },
        removeImage(state, payload) {
            state.form.images.splice(payload, 1);
        },
        setImages(state, payload) {
            state.form.images.push(payload);
        },
        emptyImages(state, payload) {
            state.form.images = [];
        },
        setUrl(state, payload) {
            state.form.url = payload;
        },
        // setForm(state, payload) {
        //     state.form.id = payload.id;
        //     state.form.featured_image = payload.featured_image;
        // },
        setForm(state, payload) {

            state.form.id = null;
            state.form.featured_image = null;
            state.form[payload?.key] = null;

            state.form.id = payload.id;
            state.form.featured_image = payload.featured_image;
            console.log('Mutation Payload:', payload);
            state.form[payload?.key] = payload.value;
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
                ? `${process.env.MIX_WEB_API_URL}events/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}events`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessage(res.data.message);
                            commit("resetForm");
                            resolve(res);
                        } else {
                            // helper.swalErrorMessage(res.data.message);
                            resolve(res);
                            
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
        fetchEvents({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}events?q=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setEvents", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchEvent({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}events/${payload.id}?q=1`;
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
        deleteEvent({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}events/${payload.id}`;
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

export default events;
