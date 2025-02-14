<template>
  <AppLayout title="CV">
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Mon CV
        </h2>
      </div>
    </template>
    <div class="flex flex-col gap-6 max-w-5xl mx-auto bg-white shadow-md mb-6">
        <!-- Header -->
        <div class="p-6 bg-white border-t border-gray-200">
          <div class="flex justify-between items-start ">
            <div class="flex items-center">
              <div class="h-4 w-1 bg-[#2b8d96] mr-2"></div>
              <h3 class="text-lg font-semibold">Informations personnelles</h3>
            </div>
            <button
              @click="showEditModal = true"
              class="inline-flex items-center justify-center p-2 rounded-full text-[#2b8d96] hover:bg-gray-100"
            >
              <svg  class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
              </svg>
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
                    <span class="ml-2">{{ formattedBirthDate }}</span>
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
                  <p class="text-sm">
                    <span class="text-gray-500">Pays :</span>
                    <span class="ml-2">{{ userInfo.country }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
          <div class="flex space-x-4">
            <button 
              @click="downloadPDF"
              class="flex items-center text-[#2b8d96] hover:text-pink-600"
            >
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
        <div class="p-6 bg-gray-50 border-t border-gray-200">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
              <div class="h-4 w-1 bg-[#2b8d96] mr-2"></div>
              <h3 class="text-lg font-semibold">Résumé de mon CV</h3>
            </div>
            <button
              @click="toggleSummaryEdit"
              class="inline-flex items-center justify-center p-2 rounded-full text-[#2b8d96] hover:bg-gray-100"
            >
              <svg v-if="!isEditing" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div v-if="!isEditing && displayedSummary" class="mb-6">
            <div class="flex items-center">
              <p class="text-gray-600 flex-1">{{ displayedSummary }}</p>
            </div>
          </div>

          <!-- Kiara Section -->
          <div v-if="isEditing" class="mt-6 bg-[#2b8d96] rounded-lg overflow-hidden">
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
                rows="2"
                class="w-full p-4 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
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
                  @click="validateSummary"
                  :disabled="!summary.trim()"
                  class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  Valider
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Education Section -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
              <div class="h-4 w-1 bg-[#2b8d96] mr-2"></div>
              <h3 class="text-lg font-semibold">Formation</h3>
            </div>
            <button
              @click="toggleEducationForm"
              class="inline-flex items-center justify-center p-2 rounded-full text-[#2b8d96] hover:bg-gray-100"
            >
              <svg v-if="!showEducationForm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div v-if="showEducationForm" class="mt-4 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-lg">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Niveau d'étude
                  </label>
                  <select
                    v-model="educationForm.level"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                  >
                    <option value="Bac +5 et plus">Bac +5 et plus</option>
                    <option value="Bac +3">Bac +3</option>
                    <option value="Bac +2">Bac +2</option>
                    <option value="Bac">Bac</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Type d'établissement
                  </label>
                  <select
                    v-model="educationForm.type"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                  >
                    <option value="Université">Université</option>
                    <option value="École d'ingénieur">École d'ingénieur</option>
                    <option value="École de commerce">École de commerce</option>
                  </select>
                </div>
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Date de début
                </label>
                <input
                  v-model="educationForm.startDate"
                  type="date"
                  class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Date de fin
                </label>
                <input
                  v-model="educationForm.endDate"
                  type="date"
                  class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Établissement
                </label>
                <input
                  v-model="educationForm.school"
                  type="text"
                  class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Diplôme
                </label>
                <input
                  v-model="educationForm.diploma"
                  type="text"
                  class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Description
                </label>
                <textarea
                  v-model="educationForm.description"
                  class="w-full h-40 p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4 flex justify-end space-x-4">
                <button
                  @click="submitEducation"
                  class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                >
                  Ajouter
                </button>
                <button
                  @click="toggleEducationForm"
                  class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                >
                  Annuler
                </button>
              </div>
            </div>
          </div>

          <div class="space-y-6">
            <div v-for="(education, index) in formations" :key="index" class="flex">
              <div class="w-48 flex-shrink-0 whitespace-nowrap">
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
          </div>
        </div>
        <!-- Experience Section -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
              <div class="h-4 w-1 bg-[#2b8d96] mr-2"></div>
              <h3 class="text-lg font-semibold">Experience professionnelle</h3>
            </div>
            <button
              @click="toggleExperienceForm"
              class="inline-flex items-center justify-center p-2 rounded-full text-[#2b8d96] hover:bg-gray-100"
            >
              <svg v-if="!showExperienceForm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div v-if="showExperienceForm" class="mt-4 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-lg">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Titre
                  </label>
                  <input
                    v-model="experienceForm.title"
                    type="text"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Entreprise
                  </label>
                  <input
                    v-model="experienceForm.company"
                    type="text"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                  />
                </div>
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Lieu
                </label>
                <input
                  v-model="experienceForm.location"
                  type="text"
                  class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Date de début
                </label>
                <input
                  v-model="experienceForm.start_date"
                  type="date"
                  class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Date de fin
                </label>
                <input
                  v-model="experienceForm.end_date"
                  type="date"
                  class="w-full p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Description
                </label>
                <textarea
                  v-model="experienceForm.description"
                  class="w-full h-40 p-2 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                />
              </div>
              <div class="mt-4 flex justify-end space-x-4">
                <button
                  @click="submitExperience"
                  class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                >
                  Ajouter
                </button>
                <button
                  @click="toggleExperienceForm"
                  class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                >
                  Annuler
                </button>
              </div>
            </div>
          </div>

          <div class="space-y-6">
            <div v-for="(experience, index) in userInfo.experiences" :key="index" class="flex">
              <div class="w-48 flex-shrink-0 whitespace-nowrap">
                <div class="text-sm text-gray-600">{{ formatDate(experience.start_date) }} - {{ formatDate(experience.end_date) }}</div>
              </div>
              <div class="flex-1">
                <h4 class="text-lg font-medium text-gray-900">{{ experience.title }}</h4>
                <div class="text-sm text-gray-600 mt-1">
                  {{ experience.company }} • {{ experience.location }}
                </div>
                <p class="mt-2 text-sm text-gray-500">{{ experience.description }}</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Language Section -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
              <div class="h-4 w-1 bg-[#2b8d96] mr-2"></div>
              <h3 class="text-lg font-semibold">Langues</h3>
            </div>
            <button
              @click="toggleLanguageModal"
              class="inline-flex items-center justify-center p-2 rounded-full text-[#2b8d96] hover:bg-gray-100"
            >
              <svg v-if="!showLanguageModal" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

        </div>
    </div>
    <!-- Language Modal -->
    <Modal :show="showLanguageModal" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
          Langues
        </h2>
        
        <form @submit.prevent="submitLanguage" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Langue</label>
              <input
                type="text"
                v-model="languageForm.language"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Niveau</label>
              <input
                type="text"
                v-model="languageForm.level"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              >
            </div>
          </div>
          <div class="mt-6 flex justify-end space-x-3">
            <button
              type="submit"
              class="inline-flex items-center justify-center p-2 rounded-sm text-white bg-[#2b8d96] hover:bg-[#1a646b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2b8d96]"
            >
              Ajouter
            </button>
            <button
                    @click="toggleLanguageModal"
                    class="px-6 py-2 bg-red-500 text-white rounded-sm hover:bg-red-700"
                  >
                    Annuler
            </button>
          </div>
        </form>
      </div>
    </Modal>
    <!-- Edit Modal -->
    <Modal :show="showEditModal" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
          Modifier mes informations
        </h2>
        
        <form @submit.prevent="updateProfile" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <!-- Civility -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Civilité</label>
              <select v-model="form.civility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]">
                <option value="M.">M.</option>
                <option value="Mme">Mme</option>
                <option value="Mlle">Mlle</option>
              </select>
            </div>

            <!-- Date of Birth -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
              <input
                type="date"
                v-model="form.date_of_birth"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              >
            </div>
            <!-- family status -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Statut familial</label>
              <select v-model="form.family_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]">
                <option value="Célibataire">Célibataire</option>
                <option value="Marie">Marie</option>
                <option value="Divorce">Divorce</option>
                <option value="Veuf">Veuf</option>
                <option value="Séparé">Séparé</option>
                <option value="Union libre">Union libre</option>                
              </select>
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Téléphone</label>
              <input
                type="tel"
                v-model="form.phone"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              >
            </div>

            <!-- Address -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Adresse</label>
              <input
                type="text"
                v-model="form.address"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              >
            </div>

            <!-- Nationality -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Nationalité</label>
              <input
                type="text"
                v-model="form.nationality"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              >
            </div>

            <!-- Study Level -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Niveau d'études</label>
              <select v-model="form.study_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]">
                <option value="Bac">Bac</option>
                <option value="Bac +2">Bac +2</option>
                <option value="Bac +3">Bac +3</option>
                <option value="Bac +4">Bac +4</option>
                <option value="Bac +5">Bac +5</option>
                <option value="Bac +5 et plus">Bac +5 et plus</option>
              </select>
            </div>

            <!-- Country -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Pays</label>
              <input
                type="text"
                v-model="form.country"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              >
            </div>

            <!-- Avatar -->
            <div class="col-span-2">
              <label class="block text-sm font-medium text-gray-700">Photo de profil</label>
              <input
                type="file"
                @change="handleAvatarUpload"
                accept="image/*"
                class="mt-1 block w-full"
              >
            </div>
          </div>

          <div class="mt-6 flex justify-end space-x-3">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Annuler
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-[#2b8d96] text-white rounded-md text-sm font-medium hover:bg-[#1a5f68]"
              :disabled="form.processing"
            >
              Enregistrer
            </button>
          </div>
        </form>
      </div>
    </Modal>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Modal from '@/Components/Modal.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  auth: Object,
  errors: Object,
  userInfo: Object,
})

const defaultAvatar = '/storage/default-avatar.png'

const formattedBirthDate = computed(() => {
  if (!props.userInfo?.birthDate) return ''
  const date = new Date(props.userInfo.birthDate)
  return date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
})

// Add download function
const downloadPDF = async () => {
  try {
    // Using window.open to trigger the download
    window.open(route('cv-pdf'), '_blank')
  } catch (error) {
    console.error('Error downloading PDF:', error)
  }
}

//Languange modal
const showLanguageModal = ref(false)
const languageForm = ref({
  language: '',
  level: '',
  description: ''
})

const toggleLanguageModal = () => {
  showLanguageModal.value = !showLanguageModal.value
  if (!showLanguageModal.value) {
    // Reset form when closing
    languageForm.value = {
      language: '',
      level: ''   
    }
  }
}

const submitLanguage = async () => {
  try {
    const response = await axios.post(route('curriculum.language.update'), languageForm.value)

    console.log(languageForm.value)
    showLanguageModal.value = false
    languageForm.value = {
      language: '',
      level: ''
    }
  } catch (error) {
    console.error('Error adding language:', error)
    if (error.response?.data?.redirect) {
      flash.error = error.response.data.message
      window.location.href = error.response.data.redirect
    } else {
      flash.error = 'Error adding language'
    }    
  }
} 

// Edit Modal
const showEditModal = ref(false)
const form = ref({
  civility: props.userInfo?.civility || '',
  date_of_birth: props.userInfo?.birthDate || '',
  phone: props.userInfo?.phone || '',
  address: props.userInfo?.address || '',
  nationality: props.userInfo?.nationality || '',
  study_level: props.userInfo?.educationLevel || '',
  country: props.userInfo?.country || '',
  family_status: props.userInfo?.familyStatus || '',  
  avatar: null
})

const closeModal = () => {
  // Reset form to current user info when closing summary
  form.value = {
    civility: props.userInfo?.civility || '',
    date_of_birth: props.userInfo?.birthDate || '',
    phone: props.userInfo?.phone || '',
    address: props.userInfo?.address || '',
    nationality: props.userInfo?.nationality || '',
    study_level: props.userInfo?.educationLevel || '',
    country: props.userInfo?.country || '',
    family_status: props.userInfo?.familyStatus || '',    
    avatar: null
  }
  showEditModal.value = false
}



const updateProfile = () => {
  const formData = new FormData()
  Object.keys(form.value).forEach(key => {
    if (form.value[key] !== null) {
      formData.append(key, form.value[key])
    }
  })

  router.post(route('curriculum.update-profile'), formData, {
    onSuccess: () => {
      closeModal()
      // Refresh the page to show updated data
      router.visit(route('curriculum.index'))
    },
    preserveScroll: true,
    preserveState: true,
  })
}

const handleAvatarUpload = (event) => {
  form.value.avatar = event.target.files[0]
}

// Resume
const summary = ref('')
const displayedSummary = ref(props.userInfo?.summary || '')
const isLoading = ref(false)
const isEditing = ref(false)
const error = ref('')

// Education form state
const showEducationForm = ref(false)
const formations = ref([])
const educationForm = ref({
  level: 'Bac +5 et plus',
  type: 'Université',
  startDate: '',
  endDate: '',
  school: '',
  diploma: '',
  description: ''
})

const toggleEducationForm = () => {
  showEducationForm.value = !showEducationForm.value
  if (!showEducationForm.value) {
    // Reset form when closing
    educationForm.value = {
      level: 'Bac +5 et plus',
      type: 'Université',
      startDate: '',
      endDate: '',
      school: '',
      diploma: '',
      description: ''
    }
  }
}

const submitEducation = () => {
  formations.value.push({
    ...educationForm.value,
    status: 'completed'
  })
  toggleEducationForm()
}

const startEdit = () => {
  isEditing.value = true
  if (displayedSummary.value) {
    summary.value = displayedSummary.value
  }
}

const validateSummary = () => {
  const resumeText = summary.value // Store the value before clearing it
  
  router.post(route('curriculum.resume.update'), {
    resume: resumeText
  }, {
    preserveScroll: true,
    onSuccess: () => {
      displayedSummary.value = resumeText
      summary.value = ''
      isEditing.value = false
    },
    onError: (errors) => {
      console.error('Error updating resume:', errors)
    }
  })
}

const cancelEdit = () => {
  isEditing.value = false
  summary.value = ''
}

const toggleSummaryEdit = () => {
  if (isEditing.value) {
    cancelEdit()
  } else {
    startEdit()
  }
}

const handleCorrection = async () => {
  if (!summary.value.trim()) return

  isLoading.value = true
  error.value = ''
  
  try {
    const response = await axios.post(route('curriculum.resume.correct'), {
      resume: summary.value
    })
    
    if (response.data.success) {
      console.log(response.data)
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

// Experience form state
const showExperienceForm = ref(false)
const experienceForm = ref({
  title: '',
  company: '',
  location: '',
  start_date: '',
  end_date: '',
  description: ''
})

const toggleExperienceForm = () => {
  showExperienceForm.value = !showExperienceForm.value
  if (!showExperienceForm.value) {
    resetExperienceForm()
  }
}

const resetExperienceForm = () => {
  experienceForm.value = {
    title: '',
    company: '',
    location: '',
    start_date: '',
    end_date: '',
    description: ''
  }
}

const submitExperience = async () => {
  try {
    const response = await axios.post(route('experience.store'), experienceForm.value)
    props.userInfo.experiences = [...(props.userInfo.experiences || []), response.data]
    toggleExperienceForm()
    flash.success = 'Experience added successfully'
  } catch (error) {
    console.error('Error adding experience:', error)
    if (error.response?.data?.redirect) {
      flash.error = error.response.data.message
      window.location.href = error.response.data.redirect
    } else {
      flash.error = 'Error adding experience'
    }
  }
}

const editExperience = async (experience) => {
  try {
    experienceForm.value = {
      id: experience.id,
      title: experience.title,
      company: experience.company,
      location: experience.location,
      start_date: experience.startDate,
      end_date: experience.endDate,
      description: experience.description
    }
    showExperienceForm.value = true
  } catch (error) {
    console.error('Error editing experience:', error)
    if (error.response?.data?.redirect) {
      flash.error = error.response.data.message
      window.location.href = error.response.data.redirect
    } else {
      flash.error = 'Error editing experience'
    }
  }
}

const deleteExperience = async (id) => {
  if (!confirm('Are you sure you want to delete this experience?')) return
  
  try {
    await axios.delete(route('experience.destroy', id))
    props.userInfo.experiences = props.userInfo.experiences.filter(exp => exp.id !== id)
    flash.success = 'Experience deleted successfully'
  } catch (error) {
    console.error('Error deleting experience:', error)
    if (error.response?.data?.redirect) {
      flash.error = error.response.data.message
      window.location.href = error.response.data.redirect
    } else {
      flash.error = 'Error deleting experience'
    }
  }
}

const formatDate = (date) => {
  if (!date) return ''
  return new Date(date).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long'
  })
}
</script>
