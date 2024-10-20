<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from '../axios';
import { useLoginState } from '../stores/LoginState';
import SubLayout from '../layouts/SubLayout.vue';


const route = useRoute()
const st = useLoginState()

const date = ref(route.query.date)
const events = ref([])
const event_date_id = ref()
const screenshots = ref([])
const index=ref(0)
const dialog = ref(false)
const file = ref([])
const url = ref()
const preview = ref(false)
const uploading = ref(false)
const errs_id = ref([])
const errs_file = ref([])

const load = async () => {
    await axios.get('/api/screenshot/show?date='+date.value)
    .then((res) => {
        events.value = res.data.detail.events
        screenshots.value = res.data.detail.screenshots
    }).catch((err) => {
        console.log(err)
        if((err.status == 401) || (err.status == 419)){
            st.logout()
        }
    })
}


const remove = async () => {
    if(screenshots.value.length){
        const i = index.value
        const id = screenshots.value[i].id
        await axios.get('/sanctum/csrf-cookie')
        .then(async (res) => {
            await axios.delete('/api/screenshot/'+id)
            .then((res) => {
                screenshots.value = screenshots.value.filter((n) => n.id !== id)
                if(screenshots.value.length > 0) {
                   if(index.value >= screenshots.value.length){
                        index.value = screenshots.value.lengh - 1
                    }
                }
            })
            .catch((err) => {
                console.log(err)
                if((err.status == 401) || (err.status == 419)){
                    st.logout()
                }
            })
        })
    }
}

const prev = () => {
    index.value = index.value - 1
    if(index.value < 0)
        index.value = screenshots.value.length - 1
}

const next = () => {
    index.value = index.value + 1
    if(index.value >= screenshots.value.length)
        index.value = 0
 }

const clear = () => {
    file.value = []
    event_date_id.value = null
    errs_id.value = [];
    errs_file.value = [];
   preview.value = false
}

const open = () => {
    clear()
    dialog.value  = true
}

const close = () => {
    dialog.value = false
    clear()
}

const upload = () => {
    errs_id.value = [];
    errs_file.value = [];
    uploading.value = true

    axios.get('/sanctum/csrf-cookie')
    .then((res) => {
        const config = {
            headers: {
                "Content-Type": "multipart/form-data",
            }
        }
        const form = new FormData()
        form.append('file', file.value)
        form.append('id', event_date_id.value)
        axios.post('/api/screenshot/upload', form, config)
        .then((res) => {
            const count =screenshots.value.push(res.data.detail)
            index.value = count - 1
            close()
        })
        .catch((err) => {
            console.log(err)
            if((err.status == 401) || (err.status == 419)){
                st.logout()
            } else if(err.status == 422){
                const errors = err.response.data.errors;
                if('file' in errors){
                    errs_file.value = errors.file
                } else {
                    errs_file.value = []
                }
                if('id' in errors){
                    errs_id.value = errors.id
                } else {
                    errs_id.value = []
                }
            }
        })
    })

    uploading.value = false
}

const change = () => {
    if(!file.value){
        return
    }
    const reader = new FileReader()
    reader.onload = (e) => {
        url.value = e.target.result
        preview.value = true
    }
    reader.readAsDataURL(file.value)
}

onMounted(() => {
    load()
})

</script>

<template>
<SubLayout title="提出スクリーンショット">
    <v-card>
        <v-card-title>
            <div class="d-flex flex-row justify-center">
                {{ date }}分
            </div>
        </v-card-title>
        <v-card-text>
            <v-window v-model="index" v-if="screenshots.length">
                <v-window-item
                    v-for="(screenshot, i) in screenshots"
                    :key="`widow-${i}`"
                >
                    <v-img
                        max-height="600"
                        :src="screenshot.url"
                    >
                    </v-img>
                    <div class="d-flex flex-row justify-center">
                        <div class="v-card-title">{{ screenshot.name }}</div>
                    </div>
                </v-window-item>
            </v-window>
            <div v-else>
                <div class="d-flex flex-row justify-center">
                    <div class="v-card-title">提出したスクショがありません</div>
                </div>
            </div>
        </v-card-text>
        <v-card-actions class="justify-space-between">
            <v-btn
                icon="mdi-chevron-left"
                @click="prev"
            >
            </v-btn>
            <v-btn
                icon="mdi-chevron-right"
                @click="next"
            >
            </v-btn>
        </v-card-actions>
    </v-card>
    <template v-slot:bottom-navigation>
        <v-btn @click="open">
            <v-icon icon="mdi-upload-box-outline"></v-icon>
            <span>アップロード</span>
        </v-btn>
        <v-btn @click="remove">
            <v-icon icon="mdi-trash-can-outline"></v-icon>
            <span>削除</span>
        </v-btn>
    </template>
    <v-dialog
        v-model="dialog"
        disabled
        persistent
        activator="parent">
        <v-card :loading="uploading">
            <v-card-ttle>スクショ・アップロード</v-card-ttle>
            <v-card-text>
                <v-file-input
                    v-model="file"
                    label="スクショ"
                    density="compact"
                    placeholder="スクリーンショットを選択してください"
                    variant="outlined"
                    show-size
                    prepend-icon="mdi-camera"
                    accept="image/*"
                    chips="true"
                    :error-messages="errs_file"
                    @change="change"
                    @click:clear="preview=false"
                >
                </v-file-input>
                <v-img
                    max-height="600"
                    :src="url"
                    v-if="preview">
                </v-img>
                <v-select
                    label="イベント"
                    v-model="event_date_id"
                    :items="events"
                    density="compact"
                    placeholder="イベントを選択してください"
                    variant="outlined"
                    :error-messages="errs_id"
                >
                </v-select>
            </v-card-text>
            <v-card-actions class="justify-space-between">
                <v-btn @click="upload">
                    <v-icon icon="mdi-upload-box-outline"></v-icon>
                    <span>アップロード</span>
                </v-btn>
                <v-btn @click="close">
                    <v-icon icon="mdi-cancel"></v-icon>
                    <span>キャンセル</span>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

</SubLayout>
</template>
