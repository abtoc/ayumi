<script setup>
import { ref, computed } from 'vue';
import axios from '../axios';
import { useLoginState } from '../stores/LoginState';

const st = useLoginState()

const visible=ref(false)
const email = ref('')
const password = ref('')
const errs_email = ref([])
const errs_password = ref([])

const dialog = computed(() => {
    return st.loginDialog
})

const login = () => {
    axios.get('/sanctum/csrf-cookie')
        .then((res) => {
            axios.post('/api/login', {
                email: email.value,
                password: password.value,
            }).then((res) => {
                console.log(res)
                st.login()
            }).catch((err) => {
                console.log(err)
                if(err.status == 401) {
                    errs_email.value = []
                    errs_password.value = ['E-Mailまたはパスワードに誤りがあります。']
                } else if(err.status == 422){
                    const errors = err.response.data.errors;
                    console.log(errors);
                    if('email' in errors){
                        errs_email.value = errors.email.concat()
                    } else {
                        errs_email.value = []
                    }
                    if('password' in errors){
                        errs_password.value = errors.password.concat()
                    } else {
                        errs_password.value = []
                    }
                } else {
                    console.log('login error:'+err.message)
                }
            })
        })
}
</script>

<template>
<v-dialog
    v-model="dialog"
    disabled
    persistent
    activator="parent">
    <v-card>
        <v-card-title>ログイン</v-card-title>
        <v-card-text>
            <v-text-field
                lavel="E-Mail"
                density="compact"
                placeholder="Emailアドレスを入力してください"
                prepend-inner-icon="mdi-email-outline"
				variant="outlined"
                type="email"
                v-model="email"
                :error-messages="errs_email">
            </v-text-field>
            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
				パスワード
            </div>
            <v-text-field
                label="パスワード"
                :type="visible ? 'text' : 'password'"
				density="compact"
                placeholder="パスワードを入力してください"
                prepend-inner-icon="mdi-lock-outline"
                variant="outlined"
                v-model="password"
                :error-messages="errs_password"
				@click:append-inner="visible = !visible">
            </v-text-field>
        </v-card-text>
        <v-card-actions class="justify-space-between">
            <v-btn @click="login">
				ログイン
			</v-btn>
            <v-btn to="/regist">
				新規登録
			</v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>
</template>
