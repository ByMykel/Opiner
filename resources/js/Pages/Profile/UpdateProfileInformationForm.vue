<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewPhoto">
                    Select A New Photo
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.native.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remove Photo
                </jet-secondary-button>

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <div class="flex justify-between">
                    <jet-label for="name" value="Name" />
                    <span class="font-medium text-sm text-gray-700 dark:text-white">{{ form.name ? form.name.length : 0 }} / 30</span>
                </div>
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" maxlength="30" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <div class="flex justify-between">
                    <jet-label for="email" value="Email" />
                    <span class="font-medium text-sm text-gray-700 dark:text-white">{{ form.email ? form.email.length : 0 }} / 255</span>
                </div>
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" maxlength="255" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Bio -->
            <div class="col-span-6 sm:col-span-4">
                <div class="flex justify-between">
                    <jet-label for="bio" value="Bio" />
                    <span class="font-medium text-sm text-gray-700 dark:text-white">{{ form.bio ? form.bio.length : 0 }} / 160</span>
                </div>
                <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm resize-none w-full"
                    id="bio"
                    rows="5"
                    v-model="form.bio"
                    maxlength="160"
                ></textarea>
                <jet-input-error :message="form.errors.bio" class="mt-2" />
            </div>

            <!-- Location -->
            <div class="col-span-6 sm:col-span-4">
                <div class="flex justify-between">
                    <jet-label for="location" value="Location" />
                    <span class="font-medium text-sm text-gray-700 dark:text-white">{{ form.location ? form.location.length : 0 }} / 30</span>
                </div>
                <jet-input id="location" type="text" class="mt-1 block w-full" v-model="form.location" maxlength="30" />
                <jet-input-error :message="form.errors.location" class="mt-2" />
            </div>

            <!-- Website -->
            <div class="col-span-6 sm:col-span-4">
                <div class="flex justify-between">
                    <jet-label for="website" value="Website" />
                    <span class="font-medium text-sm text-gray-700 dark:text-white">{{ form.website ? form.website.length : 0 }} / 100</span>
                </div>
                <jet-input id="website" type="text" class="mt-1 block w-full" v-model="form.website" maxlength="100" />
                <jet-input-error :message="form.errors.website" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    bio: this.user.bio,
                    location: this.user.location,
                    website: this.user.website,
                    photo: null,
                }),

                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => (this.photoPreview = null),
                });
            },
        },
    }
</script>
