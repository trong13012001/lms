<template>
    <div :class="$attrs.class">
        <label :for="id">{{ title }}</label>
        <div class="flex-input">
            <div class="input-upload">
                <input type="text" class="form-control input-file" :id="id" :name="name" :value="valueInput" readonly>
                <div class="btn-browser" @click="browswer()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="fa fa-filter" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    Browser
                </div>
            </div>
            <div class="btn-del" @click="remove()" v-if="valueInput">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-x" viewBox="0 0 16 16">
                    <path d="M6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708L8 8.293z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                </svg>
            </div>
        </div>

        <div class="preview" v-if="valueInput && type =='image' && multi == true">
            <div class="multi-img">
                <img :src="item" alt="preview" v-for="(item, index) in listImg" :key="index"/>
            </div>
        </div>
        <div class="preview" v-if="valueInput && type == 'image' && multi != true">
            <img :src="valueInput" alt="preview" />
        </div>

        <div class="preview" v-if="valueInput && type == 'document' || type == '3d'">
            <div class="download-document">
                <a :href="valueInput" download target="_blank">{{ basename(valueInput) }}</a>
            </div>
        </div>

        <div class="preview" v-if="valueInput && type == 'audio'">
            <audio controls>
                <source :src="valueInput" type="audio/mpeg">
            </audio>
        </div>

        <div class="preview" v-if="valueInput && type == 'video'">
            <video controls>
                <source :src="valueInput" type="video/mp4">
            </video>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'title',
        'id',
        'name',
        'type',
        'url',
        'multi',
        'value'
    ],
    data() {
        return {
            valueInput: this.value ? this.value : '',
            listImg: [],
        };
    },

    created() {
        if (this.value) {
            if(this.type == 'image') {
                this.listImg = this.value.split(",");
            }
        }
    },

    methods: {
        browswer() {
            window.open(
                this.url + "?type=" + this.type,
                "FileManager",
                "width=1000,height=600"
            );
            var self = this;
            window.SetUrl = function (items) {
                self.setValue(items);
            }
            return false
        },

        setValue(items) {
            if(this.type == 'image') {
                if (this.multi == true) {
                    this.listImg = [];
                    this.valueInput = '';
                    items.map(val => {
                        this.listImg.push(val.url);
                    })
                    this.valueInput = this.listImg.join(',');
                } else {
                    this.valueInput = items[0].url;
                }
            } else if(this.type == 'document') {
                this.valueInput = items[0].url;
            } else if(this.type == 'audio') {
                this.valueInput = items[0].url;
            } else if(this.type == 'video') {
                this.valueInput = items[0].url;
            } else if(this.type == '3d') {
                this.valueInput = items[0].url;
            }
        },

        remove() {
            this.valueInput = '';
        },

        basename(path, suffix = '') {
            let base = path.replace(/^.*[\\\/]/, '');
            if (suffix && base.endsWith(suffix)) {
                base = base.slice(0, -suffix.length);
            }
            return base;
        }
    },
};
</script>
<style lang="scss" scoped>
.flex-input {
    display: flex;
    align-items: center;
    justify-content: space-between;
    .input-upload {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
        .input-file {
            position: relative;
            flex: 1 1 auto;
            width: 1%;
            min-width: 0;
            border-radius: 6px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            color: #6f6b7d;
            background: rgba(0,0,0,0.1);
        }
        .btn-browser {
            background: #0d6efd;
            color: #fff;
            border-radius: 6px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            text-transform: uppercase;
            font-weight: 600;
            padding: 8px 10px;
            font-size: 14px;
            cursor: pointer;
            svg {
                display: inline-block;
                vertical-align: -2px;
                margin-right: 2px;
            }
        }
    }
    .btn-del {
        margin-left: 10px;
        background: #ea5455;
        color: #fff;
        padding: 10px;
        border-radius: 6px;
        cursor: pointer;
    }
}
.preview {
    img {
        border-radius: 8px;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.12),0 1px 5px 0 rgba(0,0,0,.2);
        object-fit: cover;
        width: 40%;
        margin-top: 8px;
    }
    .multi-img {
        display: flex;
        flex-wrap: wrap;
        img {
            margin-right: 10px;
            width: 25%;
        }
    }
    .download-document {
        margin-top: 8px;
    }
    audio {
        margin-top: 8px;
    }
    video {
        width: 50%;
        height: auto;
        margin-top: 8px;
    }
}
</style>
