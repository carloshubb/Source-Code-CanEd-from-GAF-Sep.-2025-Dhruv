import swal from "sweetalert2";
const helpers = {
    cutText(text, length) {
        if (text.split(" ").length > 1) {
            let string = text.substring(0, length);
            let splitText = string.split(" ");
            splitText.pop();
            return splitText.join(" ") + "...";
        } else {
            return text;
        }
    },
    formatDate(date, format) {
        return date;
    },
    capitalizeFirstLetter(string) {
        if (string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    },
    onlyNumber(number) {
        if (number) {
            return number.replace(/\D/g, "");
        } else {
            return "";
        }
    },
    formatCurrency(number) {
        if (number) {
            let formattedNumber = number.toString().replace(/\D/g, "");
            let rest = formattedNumber.length % 3;
            let currency = formattedNumber.substr(0, rest);
            let thousand = formattedNumber.substr(rest).match(/\d{3}/g);
            let separator;

            if (thousand) {
                separator = rest ? "." : "";
                currency += separator + thousand.join(".");
            }

            return currency;
        } else {
            return "";
        }
    },
    isset(obj) {
        return Object.keys(obj).length;
    },
    assign(obj) {
        return JSON.parse(JSON.stringify(obj));
    },
    delay(time) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve();
            }, time);
        });
    },
    randomNumbers(from, to, length) {
        let numbers = [0];
        for (let i = 1; i < length; i++) {
            numbers.push(Math.ceil(Math.random() * (from - to) + to));
        }

        return numbers;
    },
    replaceAll(str, find, replace) {
        return str.replace(new RegExp(find, "g"), replace);
    },
    swalSuccessMessage(message) {
        swal.fire({
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000,
            // icon: "success",
            background: "rgb(220 252 231)",
            // title: "Success",
            timerProgressBar: true,
            customClass: {
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
            },
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", swal.stopTimer);
                toast.addEventListener("mouseleave", swal.resumeTimer);
            },

            text: message,
        });
    },
    swalErrorMessage(message) {
        swal.fire({
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000,
            // icon: "error",
            background: "rgb(254 202 202)",
            // title: "Error",
            timerProgressBar: true,
            customClass: {
                title: "swalErrorClass",
                htmlContainer: "swalErrorClass",
            },
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", swal.stopTimer);
                toast.addEventListener("mouseleave", swal.resumeTimer);
            },
            text: message,
        });
    },
    updateUrlParameter(p, v, s) {
        const params = new URLSearchParams(p);
        params.delete(v);
        params.append(v, s);
        return params.toString();
    },
    thumbnailImage(image) {
        let imageArray = image?.split("/");
        if (imageArray?.length > 0) {
            return "images/thumbnail-" + imageArray[imageArray?.length - 1];
        } else {
            return image;
        }
    },
    largeImage(image) {
        let imageArray = image?.split("/");
        if (imageArray?.length > 0) {
            return "images/large-" + imageArray[imageArray?.length - 1];
        } else {
            return image;
        }
    },
    mediumImage(image) {
        let imageArray = image?.split("/");
        if (imageArray?.length > 0) {
            return "images/medium-" + imageArray[imageArray?.length - 1];
        } else {
            return image;
        }
        
    },
};

export default helpers;
