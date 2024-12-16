import { ref } from "vue";

export function useImageUpload(maxSizeMB = 3) {
    const imageFile = ref<File | null>(null);
    const imageError = ref<string>("");

    const handleImageUpload = (event: Event) => {
        const file = (event.target as HTMLInputElement).files?.[0];
        if (file) {
            if (file.size > maxSizeMB * 1024 * 1024) {
                imageError.value = `Image size must be less than ${maxSizeMB}MB`;
                imageFile.value = null;
            } else {
                imageError.value = "";
                imageFile.value = file;
            }
        }
    };

    return {
        imageFile,
        imageError,
        handleImageUpload,
    };
}
