let vm = new Vue({
    el: "#menu",
    data: {
        menu: false,
        class_name: "fa-bars",
        active: ""
    },
    methods: {
        toggleMenu() {
            this.menu ^= true
            console.log(this.menu)
            if (this.menu == true) {
                this.class_name = "fa-times"
                this.active = "active"
            } else {
                this.class_name = "fa-bars"
                this.active = ""
            }
            console.log(this.class_name)
        }
    },
});