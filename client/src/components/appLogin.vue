<template>
    <v-layout row justify-center>
        <v-flex xs12 sm5>
            <v-card>
                <v-card-title primary-title>
                    <div class="header">
                        <h3>Вход</h3>
                    </div>
                </v-card-title>
                <v-card-text>
                    <div>
                        Войдите чтобы продолжить
                    </div>
                </v-card-text>
                <v-card-text>
                    <v-form v-model="isLogin">
                        <v-text-field
                                v-model="login"
                                :rules="loginRules"
                                :counter="50"
                                label="Логин"
                                required
                        ></v-text-field>

                        <v-text-field
                                type="password"
                                v-model="password"
                                :rules="passwordRules"
                                label="Пароль"
                                required
                        ></v-text-field>
                        <v-btn
                                :loading="login_loading"
                                :disabled="login_loading"
                                class="green white--text"
                                @click.native="logAuth = 'login_loading'"
                        >
                            Войти
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "appLogin",
        data (){
            return{
                isLogin: false,
                loginRules: [
                    v => !!v || 'Введите логин',
                    v => v.length <= 50 || 'Логин не может быть больше 50 знаков'
                ],
                login: '',

                passwordRules: [
                    v => !!v || 'Введите пароль',
                ],
                password: '',

                logAuth: null,
                login_loading: false
            }
        },
        watch:{
            logAuth (){
                var l = this.logAuth;
                this[l] = !this[l];

                setTimeout(() => (this[l] = false), 3000);

                this.logAuth = null;
            }
        }
    }
</script>

<style src="../assets/sass/components/appLogin.scss" lang="scss"/>