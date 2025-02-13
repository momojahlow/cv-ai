<template>
  <AppLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajouter une expérience</h2>
    </template>

    <Head title="Mon CV" />
    
    <div class="min-h-screen bg-gray-100 py-6">
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
          <!-- Header -->
          <div class="p-6">
            <div class="flex justify-between items-start">
              <h1 class="text-2xl font-bold text-[#2b8d96]">Mon CV</h1>
              <button class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded">
                Modifier
              </button>
            </div>
          </div>

          <!-- Profile Section -->
          <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex space-x-6">
              <div class="w-32">
                <img
                  :src="defaultAvatar"
                  alt="Profile"
                  class="w-full h-32 object-cover rounded-lg bg-gray-200"
                />
              </div>
              <div class="flex-1">
                <h2 class="text-xl font-semibold text-gray-700">{{ userInfo.name }}</h2>
                <p class="text-gray-600">{{ userInfo.title }}</p>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">
                    {{ userInfo.categories.join(' / ') }}
                  </p>
                </div>
                
                <div class="mt-4 grid grid-cols-2 gap-4">
                  <div>
                    <p class="text-sm">
                      <span class="text-gray-500">Date de naissance :</span>
                      <span class="ml-2">{{ userInfo.birthDate }}</span>
                    </p>
                    <p class="text-sm">
                      <span class="text-gray-500">Nationalité :</span>
                      <span class="ml-2">{{ userInfo.nationality }}</span>
                    </p>
                    <p class="text-sm">
                      <span class="text-gray-500">Situation familiale :</span>
                      <span class="ml-2">{{ userInfo.familyStatus }}</span>
                    </p>
                    <p class="text-sm">
                      <span class="text-gray-500">Niveau d'étude :</span>
                      <span class="ml-2">{{ userInfo.educationLevel }}</span>
                    </p>
                  </div>
                  <div>
                    <p class="text-sm">
                      <span class="text-gray-500">Adresse :</span>
                      <span class="ml-2">{{ userInfo.address }}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex space-x-4">
              <button class="flex items-center text-[#2b8d96] hover:text-pink-600">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                </svg>
                Version PDF
              </button>
              <!-- <button class="flex items-center text-[#2b8d96] hover:text-pink-600">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
                Envoyer ce CV par mail
              </button> -->
              <button class="flex items-center text-[#2b8d96] hover:text-pink-600">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 014 16a5.986 5.986 0 004.546-2.084A5 5 0 0014 10z" clip-rule="evenodd" />
                </svg>
                Version Web
              </button>
            </div>
          </div>

          <!-- Resume Section -->
          <div class="p-6 border-t border-gray-200">
            <div class="flex items-center mb-4">
              <div class="h-4 w-1 bg-[#2b8d96] mr-2"></div>
              <h3 class="text-lg font-semibold">Résumé de mon CV</h3>
            </div>

            <div v-if="displayedSummary" class="mb-6">
              <div class="flex justify-between items-start mb-2">
                <div class="flex-1 p-4 bg-gray-50 rounded-lg border border-gray-200">
                  <p class="text-gray-700 leading-relaxed">{{ displayedSummary }}</p>
                </div>
                <button
                  @click="startEdit"
                  class="ml-4 px-4 py-2 text-sm text-[#2b8d96] hover:bg-gray-100 rounded-lg border border-[#2b8d96]"
                >
                  <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Modifier
                </button>
              </div>
            </div>
            
            <!-- Kiara Section -->
            <div v-show="!displayedSummary || isEditing" class="mt-6 bg-[#2b8d96] rounded-lg overflow-hidden">
              <div class="p-6 text-white flex justify-between items-center">
                <div>
                  <h2 class="text-3xl font-bold mb-2">Quelques secondes pour convaincre.</h2>
                  <p class="text-lg">Générez un résumé de CV percutant grâce à GEO-IA.</p>
                </div>
                <div class="text-4xl font-bold text-[#1a526a]">
                  GEO<span class="text-yellow-400">AI</span>
                </div>
              </div>
              
              <div class="bg-white p-6">
                <p class="text-gray-600 text-sm italic mb-4">
                  Rédigez ci-dessous un résumé de votre carrière et de vos aspirations professionnelles. 
                  GEO-AI peut vous faire ici un résumé sur la base de votre CV joint.
                  Êtes-vous prêt à utiliser la puissance de l'IA ?!
                </p>
                
                <textarea
                  v-model="summary"
                  class="w-full h-40 p-4 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                  placeholder="Écrivez votre résumé ici..."
                />
                <div v-if="error" class="mt-2 text-red-500">{{ error }}</div>
                
                <div class="mt-4 flex justify-end space-x-4">
                  <button
                    @click="handleCorrection"
                    :disabled="isLoading || !summary.trim()"
                    class="px-6 py-2 bg-[#2b8d96] text-white rounded-lg hover:bg-[#1a526a] disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    {{ isLoading ? 'Correction en cours...' : 'Corriger avec GEO-AI' }}
                  </button>
                  <button
                    v-if="!isEditing"
                    @click="validateSummary"
                    :disabled="!summary.trim()"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    Valider
                  </button>
                  <button
                    v-else
                    @click="updateSummary"
                    :disabled="!summary.trim()"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    Mettre à jour
                  </button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Education Section -->
          <div class="p-6 border-t border-gray-200">
            <div class="flex items-center mb-6">
              <div class="h-4 w-1 bg-[#2b8d96] mr-2"></div>
              <h3 class="text-lg font-semibold">Formation</h3>
            </div>
          </div>

          <div class="space-y-6">
  <div v-for="education in userInfo.education" :key="education.diploma" class="flex">
    <div class="w-32 flex-shrink-0">
      <div class="text-sm text-gray-600">{{ education.startDate }} - {{ education.endDate }}</div>
    </div>
    <div class="flex-1">
      <h4 class="text-lg font-medium text-gray-900">{{ education.diploma }}</h4>
      <div class="text-sm text-gray-600 mt-1">{{ education.school }}</div>
      <div class="mt-2 flex items-center space-x-4">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
          {{ education.level }}
        </span>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
          {{ education.type }}
        </span>
      </div>
      <p class="mt-2 text-sm text-gray-500">{{ education.description }}</p>
    </div>
  </div>

  <!-- Add Education Button -->
  <div class="mt-4">
    <button class="inline-flex items-center px-4 py-2 text-sm text-[#2b8d96] hover:bg-gray-100 rounded-lg border border-[#2b8d96]">
      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      Ajouter une formation
    </button>
  </div>
</div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import defaultAvatar from '@/Images/profil.jpg'
import axios from 'axios'

defineProps({
  userInfo: {
    type: Object,
    required: true
  },
  auth: {
    type: Object,
    required: true
  }
})

const summary = ref('')
const displayedSummary = ref('')
const isLoading = ref(false)
const isEditing = ref(false)
const error = ref('')

const validateSummary = () => {
  displayedSummary.value = summary.value
  summary.value = ''
}

const startEdit = () => {
  isEditing.value = true
  summary.value = displayedSummary.value
}

const updateSummary = () => {
  displayedSummary.value = summary.value
  summary.value = ''
  isEditing.value = false
}

const handleCorrection = async () => {
  if (!summary.value.trim()) return

  isLoading.value = true
  error.value = ''
  
  try {
    const response = await axios.post(route('experience.correct-description'), {
      description: summary.value
    })
    
    if (response.data.success) {
      summary.value = response.data.description
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
</script>
