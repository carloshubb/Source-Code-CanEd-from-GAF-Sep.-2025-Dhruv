const menu = {
    namespaced: true,
    state: {
        isBurgerMenu:true
    },
    mutations: {
        setIsBurgerMenu(state) {
            state.isBurgerMenu = !state.isBurgerMenu;
        },
    },
};

export default menu;
