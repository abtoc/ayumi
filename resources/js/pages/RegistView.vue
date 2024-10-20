<script setup>
import { ref } from 'vue';
import { useLoginState } from '../stores/LoginState';
import router from '../router';
import SubLayout from '../layouts/SubLayout.vue';

const st = useLoginState()

const email=ref('')
const name=ref('')
const password=ref('')
const password_confirmation=ref('')

const visible=ref(false)
const visible2=ref(false)
const errs_email=ref([])
const errs_name=ref([])
const errs_password=ref([])

const regist = () => {
    axios.get('/sanctum/csrf-cookie')
        .then((res) => {
            axios.post('/api/register', {
                email: email.value,
                name: name.value,
                password: password.value,
                password_confirmation: password_confirmation.value,
            }).then((res) => {
                console.log(res)
                st.login()
                router.push('/')
            }).catch((err) => {
                console.log(err)
                if(err.status == 401) {
                    errs_email.value = []
                    errs_name.value = []
                    errs_password.value = ['E-Mailまたはパスワードに誤りがあります。']
                } else if(err.status == 422){
                    const errors = err.response.data.errors;
                    console.log(errors);
                    if('email' in errors){
                        errs_email.value = errors.email.concat()
                    } else {
                        errs_email.value = []
                    }
                    if('name' in errors){
                        errs_name.value = errors.name.concat()
                    } else {
                        errs_name.value = []
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
<SubLayout title="ユーザ登録">
    <v-card>
        <v-card-title>ユーザ登録</v-card-title>
        <v-card-text>
            <v-text-field
                label="E-Mail"
                density="compact"
                placeholder="Emailアドレスを入力してください"
                prepend-inner-icon="mdi-email-outline"
				variant="outlined"
                type="email"
                v-model="email"
                :error-messages="errs_email">
            </v-text-field>
            <v-text-field
                label="名前"
                density="compact"
                placeholder="ミクチャ名を入れてください"
                prepend-inner-icon="mdi-account-outline"
				variant="outlined"
                v-model="name"
                :error-messages="errs_name">
            </v-text-field>
            <v-text-field
                label="パスワード"
                :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                :type="visible ? 'text' : 'password'"
				density="compact"
                placeholder="パスワードを入力してください"
                prepend-inner-icon="mdi-lock-outline"
                variant="outlined"
                v-model="password"
                :error-messages="errs_password"
				@click:append-inner="visible = !visible">
            </v-text-field>
            <v-text-field
                label="パスワード確認用"
                :append-inner-icon="visible2 ? 'mdi-eye-off' : 'mdi-eye'"
                :type="visible2 ? 'text' : 'password'"
				density="compact"
                placeholder="確認用パスワードを入力してください"
                prepend-inner-icon="mdi-lock-outline"
                variant="outlined"
                v-model="password_confirmation"
				@click:append-inner="visible2 = !visible2">
            </v-text-field>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="regist">
				登録
			</v-btn>
        </v-card-actions>
    </v-card>
</SubLayout>
</template>
