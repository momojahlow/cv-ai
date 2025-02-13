<template>
  <form @submit.prevent="submit" class="space-y-6">
    <div>
      <InputLabel for="title" value="Titre du poste" />
      <TextInput
        id="title"
        type="text"
        class="mt-1 block w-full"
        v-model="form.title"
        required
        autofocus
      />
      <InputError class="mt-2" :message="form.errors.title" />
    </div>

    <div>
      <InputLabel for="company" value="Entreprise" />
      <TextInput
        id="company"
        type="text"
        class="mt-1 block w-full"
        v-model="form.company"
        required
      />
      <InputError class="mt-2" :message="form.errors.company" />
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <InputLabel for="start_date" value="Date de début" />
        <TextInput
          id="start_date"
          type="date"
          class="mt-1 block w-full"
          v-model="form.start_date"
          required
        />
        <InputError class="mt-2" :message="form.errors.start_date" />
      </div>

      <div>
        <InputLabel for="end_date" value="Date de fin" />
        <TextInput
          id="end_date"
          type="date"
          class="mt-1 block w-full"
          v-model="form.end_date"
        />
        <InputError class="mt-2" :message="form.errors.end_date" />
      </div>
    </div>

    <div>
      <InputLabel for="description" value="Description" />
      <textarea
        id="description"
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        v-model="form.description"
        rows="4"
        required
      ></textarea>
      <InputError class="mt-2" :message="form.errors.description" />
      <div class="mt-2">
        <button
          type="button"
          @click="handleCorrection"
          :disabled="isLoading || !form.description.trim()"
          class="inline-flex items-center px-4 py-2 bg-[#2b8d96] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1a526a] focus:bg-[#1a526a] active:bg-[#1a526a] focus:outline-none focus:ring-2 focus:ring-[#2b8d96] focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
        >
          {{ isLoading ? 'Correction en cours...' : 'Corriger avec GEO-AI' }}
        </button>
        <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
      </div>
    </div>

    <div>
      <InputLabel for="location" value="Lieu" />
      <TextInput
        id="location"
        type="text"
        class="mt-1 block w-full"
        v-model="form.location"
        required
      />
      <InputError class="mt-2" :message="form.errors.location" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Ajouter l'expérience
      </PrimaryButton>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import axios from 'axios'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'

const isLoading = ref(false)
const error = ref('')

const form = useForm({
  title: '',
  company: '',
  location: '',
  start_date: '',
  end_date: '',
  description: '',
})

const handleCorrection = async () => {
  if (!form.description.trim()) return

  isLoading.value = true
  error.value = ''
  
  try {
    const response = await axios.post(route('experience.correct-description'), {
      description: form.description
    })
    
    if (response.data.success) {
      form.description = response.data.description
    } else {
      error.value = response.data.message || 'Une erreur est survenue lors de la correction'
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Une erreur est survenue lors de la correction'
    console.error('Erreur lors de la correction:', err)
  } finally {
    isLoading.value = false
  }
}

const submit = () => {
  form.post(route('experience.store'), {
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>
