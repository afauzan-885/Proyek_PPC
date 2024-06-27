function passwordValidation() {
    return {
        password: "",
        passwordConfirmation: "",
        passwordStrength: 0,
        passwordStrengthDescription: "Lemah",
        checkPasswordStrength() {
            let strength = 0;
            if (this.password.length > 8) strength += 15;
            if (this.password.match(/[a-z]+/)) strength += 15;
            if (this.password.match(/[A-Z]+/)) strength += 25;
            if (this.password.match(/[0-9]+/)) strength += 20;
            if (this.password.match(/[!@#$%^&*()_+=P?/>.,<]+/)) strength += 25;
            this.passwordStrength = strength;
            this.passwordStrengthDescription =
                this.getPasswordStrengthDescription(strength);
        },
        getPasswordStrengthDescription(strength) {
            if (strength < 33) return "Lemah";
            if (strength < 66) return "Sedang";
            if (strength < 89) return "Kuat";
            return "Sangat Kuat";
        },
        passwordMatch() {
            return this.password === this.passwordConfirmation;
        },
        passwordStrengthClass() {
            return {
                "bg-danger": this.passwordStrength < 33,
                "bg-warning":
                    this.passwordStrength >= 33 && this.passwordStrength < 66,
                "bg-success": this.passwordStrength >= 66,
            };
        },
    };
}
