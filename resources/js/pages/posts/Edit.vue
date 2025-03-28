<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Post, PostForm, type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Post',
        href: '/posts',
    },
];

const { currentPost } = defineProps<{ currentPost: Post }>();

const form = useForm<PostForm>({
    title: currentPost.title,
    content: currentPost.content,
    image: null,
    _method: 'PUT',
});

const imagePreview = ref<string | null>(null);

const submit = () => {
    form.post(route('posts.update', currentPost.id), {
        preserveScroll: true,
        onSuccess: () => {
            // Success message
        },
    });
};

const handleImageInput = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};
</script>

<template>

    <Head title="Edit Post" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="min-w-md mx-auto p-6 mt-8 bg-white dark:bg-neutral-800 rounded-xl shadow-lg">
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-200 mb-2">Create a new post</h1>
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="title">Title</Label>
                            <Input id="title" type="text" :tabindex="1" autofocus v-model="form.title"
                                placeholder="First Post" />
                            <InputError :message="form.errors.title" />
                        </div>
                    </div>
                    <div class="grid gap-2">
                        <Label for="title">Image</Label>
                        <Input id="image" type="file" :tabindex="2" @change="handleImageInput"
                            placeholder="Select an image" />
                        <InputError :message="form.errors.image" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="content">Content</Label>
                        <Textarea id="content" :tabindex="3" v-model="form.content"
                            placeholder="Write your post content here" />
                        <div class="flex space-x-2">
                            <img v-if="imagePreview || currentPost.image" :src="imagePreview || currentPost.image"
                                class="w-full h-48 object-cover rounded-lg" />
                        </div>
                        <InputError :message="form.errors.content" />


                        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Update Post
                        </Button>
                    </div>


                </form>
            </div>
        </div>
    </AppLayout>
</template>