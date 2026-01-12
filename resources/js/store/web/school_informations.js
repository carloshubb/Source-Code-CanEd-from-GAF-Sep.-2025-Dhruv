import ErrorHandling from "../../ErrorHandling";

const school_informations = {
    namespaced: true,
    state: {
        errors: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            website_url: "",
            email: "",
            phone: "",
            time: "",
            time_zone: "",
            province: "",
            youtube_link: "",
            // degree_id: "",
            image: "",
            country: "",
            facebook: "",
            linkedin: "",
            insta: "",
            twitter: "",
            youtube: "",
            vk: "",
            main_button_link: "",
            other_button_link: "",
            quick_facts_status: "",
            overview_status: "",
            program_status: "",
            admission_status: "",
            financial_status: "",
            scholarship_status: "",
            contacts_status: "",
            school_name: {},
            description: {},
            more_button_title: {},
            more_button_sub_title: {},
            other_button_title: {},
            languages: [],
            more_images:[],
            school_more_links:[]
        },
        school_informations: null,
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
        removeImage(state,payload){
            state.form.more_images.splice(payload,1);
        },
        setImages(state,payload){
            state.form.more_images.push(payload);
        },
        setMoreLinks(state,payload){
            state.form.school_more_links.push(payload);
        },
        unSetMoreLinks(state,payload){
            state.form.school_more_links = [];
        },
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
        setSchoolInformation(state, payload) {
            const {
                id,
                customer_id,
                website_url,
                email,
                phone,
                time,
                time_zone,
                province,
                youtube_link,
                image,
                country,
                facebook,
                linkedin,
                insta,
                twitter,
                youtube,
                vk,
                main_button_link,
                other_button_link,
                quick_facts_status,
                overview_status,
                program_status,
                admission_status,
                financial_status,
                scholarship_status,
                contacts_status,
            } = payload;
            state.form["id"] = id;
            state.form["website_url"] = website_url;
            state.form["time"] = time;
            state.form["time_zone"] = time_zone;
            state.form["phone"] = phone;
            state.form["email"] = email;
            state.form["province"] = province;
            state.form["youtube_link"] = youtube_link;
            state.form["country"] = country;
            state.form["image"] = image;
            state.form["facebook"] =facebook;
            state.form["linkedin"] = linkedin;
            state.form["insta"] = insta;
            state.form["twitter"] =twitter ;
            state.form["youtube"] = youtube;
            state.form["vk"] =vk ;
            state.form["main_button_link"] = main_button_link;
            state.form["other_button_link"] = other_button_link;
            state.form["quick_facts_status"] = quick_facts_status;
            state.form["overview_status"] = overview_status;
            state.form["program_status"] = program_status;
            state.form["admission_status"] = admission_status;
            state.form["financial_status"] = financial_status;
            state.form["scholarship_status"] = scholarship_status;
            state.form["contacts_status"] = contacts_status;

            
            for (
                let i = 0;
                i < payload?.school_information_detail?.length;
                i++
            ) {
                if (
                    payload?.school_information_detail[i] &&
                    payload?.school_information_detail[i]?.language_code
                ) {
                    state.form["school_name"][
                        "school_name" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] = payload?.school_information_detail[i]?.school_name;
                    state.form["description"][
                        "description" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] = payload?.school_information_detail[i]?.description;

                    state.form["more_button_title"][
                        "more_button_title" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] = payload?.school_information_detail[i]?.more_button_title;

                    state.form["more_button_sub_title"][
                        "more_button_sub_title" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] = payload?.school_information_detail[i]?.more_button_sub_title;

                    state.form["other_button_title"][
                        "other_button_title" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] = payload?.school_information_detail[i]?.other_button_title;
                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.school_informations = payload;
        },
        setSchoolInformations(state, payload) {
            state.school_informations = payload;
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
                // degree_id: "",
                website_url: "",
                email: "",
                phone: "",
                time: "",
                time_zone: "",
                province: "",
                youtube_link: "",
                image: "",
                country: "",
                facebook: "",
                linkedin: "",
                insta: "",
                twitter: "",
                youtube: "",
                vk: "",
                main_button_link: "",
                other_button_link: "",
                quick_facts_status: "",
                overview_status: "",
                program_status: "",
                admission_status: "",
                financial_status: "",
                scholarship_status: "",
                contacts_status: "",
                ambassador_status:"",
                school_name: {},
                description: {},
                more_button_title: {},
                more_button_sub_title: {},
                other_button_title: {},
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
                ? `${process.env.MIX_WEB_API_URL}school-informations/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school-informations`;
            commit("setLoading");

            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessage(res.data.message);
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
        fetchSchoolInformations({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-informations?withSchoolInformationDetail=1&type=${payload?.type}`;
            url = `${url}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolInformations", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolInformation({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-informations/${payload.id}?withSchoolInformationDetail=1`;
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
        deleteSchoolInformation({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-informations/${payload.id}`;
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

export default school_informations;
