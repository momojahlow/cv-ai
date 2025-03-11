<template>
  <AppLayout title="CV">
    <Head title="MON CV" />
    <div class="flex flex-col gap-6 max-w-5xl mx-auto bg-white shadow-md mb-6">
        <!-- Header -->
        <div class="p-6 bg-white border-t border-gray-200">
          <div class="flex justify-between items-start ">
            <div :class="`flex items-center text-${colorSetting}`">
              <div :class="`h-4 w-1 bg-${colorSetting} mr-2`"></div>
              <h3 class="text-lg font-semibold">Informations personnelles</h3>
            </div>
            <button @click="showProfilModal = true"
              :class="`inline-flex items-center justify-center p-2 rounded-full text-${colorSetting} hover:bg-gray-100`"
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
              <img :src="avatarUrl" alt="Profile" class="w-full h-32 object-cover  bg-gray-200" />
            </div>
            <div class="flex-1">
              <h2 class="text-xl font-semibold text-gray-700">{{ userInfo.name }}</h2>
              <p class="text-gray-600">{{ userInfo.title }}</p>
              <!-- <div class="mt-2">
                <p class="text-sm text-gray-500">
                  {{ userInfo.categories.join(' / ') }}
                </p>
              </div> -->

              <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                  <p class="text-sm">
                    <span class="text-gray-500">Date de naissance :</span>
                    <span class="ml-2">{{ formattedNormalDate(userInfo.date_of_birth) }}</span>
                  </p>
                  <p class="text-sm">
                    <span class="text-gray-500">Nationalité :</span>
                    <span class="ml-2">{{ userInfo.nationality }}</span>
                  </p>
                  <p class="text-sm">
                    <span class="text-gray-500">Situation familiale :</span>
                    <span class="ml-2">{{ userInfo.family_status }}</span>
                  </p>
                  <p class="text-sm">
                    <span class="text-gray-500">Niveau d'étude :</span>
                    <span class="ml-2">{{ userInfo.study_level }}</span>
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
          <div class="flex space-x-4 justify-between">
            <div class="flex space-x-4">
              <button @click="downloadPDF" :disabled = "isLoading"
                :class="['flex items-center', `text-${colorSetting}`, 'hover:text-pink-600']"
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
              <a :href="`/cv-web/${auth.user.id}/${colorSetting}`" target="_blank" :class="`flex items-center text-${colorSetting} hover:text-pink-600`">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 014 16a5.986 5.986 0 004.546-2.084A5 5 0 0014 10z" clip-rule="evenodd" />
                </svg> Version Web
              </a>
              <div v-if="$page.props.flash.error" class="text-red-500 text-sm">
                {{ $page.props.flash.error }}
              </div>
            </div>
            <div class="flex space-x-4 items-center">
              <div class="text-sm text-gray-500">Couleur du CV</div>
              <label class="relative flex items-center cursor-pointer">
                <input  type="radio"  v-model="colorSetting" value="primary" name="cvColor"   class="hidden peer"  />
                <div class="w-6 h-6 rounded-full border-2 border-primary flex items-center justify-center">
                  <div v-show="colorSetting === 'primary'" class="w-3 h-3 bg-primary rounded-full"></div>
                </div>
              </label>

              <label class="relative flex items-center cursor-pointer">
                <input
                  type="radio"
                  v-model="colorSetting"
                  value="secondary"
                  name="cvColor"
                  class="hidden peer"
                />
                <div class="w-6 h-6 rounded-full border-2 border-secondary flex items-center justify-center">
                  <div v-show="colorSetting === 'secondary'" class="w-3 h-3 bg-secondary rounded-full"></div>
                </div>
              </label>

              <label class="relative flex items-center cursor-pointer">
                <input  type="radio"  v-model="colorSetting" value="danger" name="cvColor"   class="hidden peer"   />
                <div class="w-6 h-6 rounded-full border-2 border-danger flex items-center justify-center">
                  <div v-show="colorSetting === 'danger'" class="w-3 h-3 bg-danger rounded-full"></div>
                </div>
              </label>
            </div>
          </div>
        </div>
        <!-- GEO-AI Section -->
        <div class="mt-6 bg-danger overflow-hidden">
          <div class="p-6 text-white flex justify-between items-center">
            <div>
              <h2 class="text-3xl font-bold mb-2">Quelques secondes pour convaincre.</h2>
              <p class="text-lg">Générez un résumé de CV percutant grâce à HOKOUKI <span class="text-gray-300">EMPLOI</span>.</p>
            </div>
            <div class="text-4xl font-bold text-white">
              HOKOUKI<span class="text-gray-300"> EMPLOI</span>
            </div>
          </div>
          <div class="bg-white p-6">
            <p class="text-gray-600 text-sm italic">
              Rédigez ci-dessous un résumé de votre carrière et de vos aspirations professionnelles.
              GEO-AI peut vous faire ici un résumé sur la base de votre CV joint.
              Êtes-vous prêt à utiliser la puissance de l'IA ?!
            </p>
          </div>
        </div>

        <!-- Resume Section -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
          <div class="flex items-center justify-between mb-6">
            <div :class="`flex items-center text-${colorSetting}`">
              <div :class="`h-4 w-1 bg-${colorSetting} mr-2`"></div>
              <h3 class="text-lg font-semibold">Résumé de mon CV</h3>
            </div>
            <button @click="toggleSummaryEdit"
              :class="`inline-flex items-center justify-center p-2 rounded-full text-${colorSetting} hover:bg-gray-100`"
            >
              <svg v-if="!isEditingSummary" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
              </svg>
              <svg v-else class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div v-if="!isEditingSummary && formSummary.resume" class="mb-6 text-gray-600">{{ formSummary.resume }}</div>
          <!-- Resume form Section -->
          <div v-if="isEditingSummary" class="bg-white overflow-hidden shadow-lg">
            <div class="px-4 py-6">
              <textarea v-model="formSummary.resume" rows="4" placeholder="Écrivez votre résumé ici..."
                class="w-full p-4 border border-gray-300 focus:border-[#2b8d96] focus:ring-[#2b8d96]"                
              />
              <div v-if="formSummary.errors.resume" class="mt-1 text-xs text-red-500">{{ formSummary.errors.resume }}</div>
              <div v-if="formErrors.resume" class="mt-1 text-xs text-red-500">{{ formErrors.resume[0] }}</div>
              <div class="mt-4 flex justify-end space-x-4">
                <button @click="correctSummary(formSummary.resume)" 
                  :disabled="isLoading || !formSummary.resume?.trim() || formSummary.processing"
                  class="px-6 py-2 bg-[#2b8d96] text-white hover:bg-[#1a526a] disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isLoading ? 'Correction en cours...' : 'Corriger avec HOKOUI-EMPLOI' }}
                </button>
                <button @click="validateSummary" :disabled="!formSummary.resume?.trim() || formSummary.processing || isLoading"
                  class="px-6 py-2 bg-secondary text-white hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
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
            <div :class="`flex items-center text-${colorSetting}`">
              <div :class="`h-4 w-1 bg-${colorSetting} mr-2`"></div>
              <h3 class="text-lg font-semibold">Formation</h3>
            </div>
            <button type="button" @click="showEducationModal = true"
              :class="`inline-flex items-center justify-center p-2 rounded-full text-${colorSetting} hover:bg-gray-100`"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
            </button>
          </div>

          <div class="space-y-6">
            <template v-if="userInfo.educations?.length">
              <div v-for="(education, index) in userInfo.educations" :key="index" class="flex">
                <div class="w-48 flex-shrink-0 whitespace-nowrap">
                  <div class="text-sm text-gray-600">
                    {{ formatSortedDate(education.start_date) }} - {{ formatSortedDate(education.end_date) }}
                  </div>
                </div>
                <div class="flex-1">
                  <div class="flex justify-between">
                    <div>
                      <h4 class="text-lg font-medium text-gray-900">{{ education.diploma }}</h4>
                      <div class="mt-2 flex items-center space-x-4">
                        <div class="text-sm text-gray-600 mt-1">{{ education.school }} • </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                          {{ education.city }} •
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          {{ education.country }} •
                        </span>
                      </div>
                    </div>
                    <div class="flex space-x-2 p-2">
                      <button
                        @click="editEducation(education)"
                        class="text-[#2b8d96] hover:text-[#1a646b]"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                      <button
                        @click="deleteEducation(education.id)"
                        class="text-red-500 hover:text-red-700"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div class="mt-2 flex items-center space-x-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      {{ education.level }} •
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      {{ education.type }} •
                    </span>
                  </div>
                  <p class="mt-2 text-sm text-gray-500">{{ education.description }}</p>
                </div>
              </div>
            </template>
            <div v-else class="text-gray-500 text-center py-4">
              Aucune formation ajoutée
            </div>
          </div>
        </div>
        <!-- Experience Section -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
          <div class="flex items-center justify-between mb-6">
            <div :class="`flex items-center text-${colorSetting}`">
              <div :class="`h-4 w-1 bg-${colorSetting} mr-2`"></div>
              <h3 class="text-lg font-semibold">Experience professionnelle</h3>
            </div>
            <button type="button" @click="showExperienceModal = true"
              :class="`inline-flex items-center justify-center p-2 rounded-full text-${colorSetting} hover:bg-gray-100`"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
            </button>
          </div>

          <div class="space-y-6">
            <template v-if="userInfo.experiences?.length">
              <div v-for="(experience, index) in userInfo.experiences" :key="index" class="flex gap-2">
                <div class="w-48 flex-shrink-0 whitespace-nowrap overflow-hidden">
                  <div class="text-sm text-gray-600">{{ formatSortedDate(experience.start_date) }} - {{ formatSortedDate(experience.end_date) }}</div>
                </div>
                <div class="flex-1">
                  <div class="flex justify-between">
                    <div>
                      <h4 class="text-lg font-medium text-gray-900">{{ experience.title }}</h4>
                      <div class="text-sm text-gray-600 mt-1">
                        {{ experience.company }} • {{ experience.location }}
                      </div>
                    </div>
                    <div class="flex space-x-2 p-2">
                      <button type="button" @click="editExperience(experience)" class="text-[#2b8d96] hover:text-[#1a646b]" >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                      <button type="button" @click="deleteExperience(experience.id)" class="text-red-500 hover:text-red-700" >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <p class="mt-2 text-sm text-gray-500">{{ experience.description }}</p>
                </div>
              </div>
            </template>
            <div v-else class="text-gray-500 text-center py-4">
              Aucune expérience ajoutée
            </div>
          </div>
        </div>
        <!-- Language Section -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
          <div class="flex items-center justify-between mb-6">
            <div :class="`flex items-center text-${colorSetting}`">
              <div :class="`h-4 w-1 bg-${colorSetting} mr-2`"></div>
              <h3 class="text-lg font-semibold">Langues</h3>
            </div>
            <button @click="showLanguageModal = true"
              :class="`inline-flex items-center justify-center p-2 rounded-full text-${colorSetting} hover:bg-gray-100`"
            >
              <svg v-if="!showLanguageModal" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="mt-6 bg-white shadow rounded-lg">
            <!-- Display languages -->
            <div class="space-y-2">
              <template v-if="props.userInfo.languages?.length">
                <div
                  v-for="(lang, index) in props.userInfo.languages"
                  :key="index"
                  class="flex justify-between items-center p-3 bg-gray-50 rounded-md"
                >
                  <div>
                    <span class="font-medium">{{ lang.name }}</span>
                    <span class="text-gray-500 ml-2">- {{ lang.level }}</span>
                  </div>
                  <div class="flex space-x-2">
                    <button
                      @click="editLanguage(lang)"
                      class="text-[#2b8d96] hover:text-[#1a646b]"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>
                    <button
                      @click="deleteLanguage(lang.id)"
                      class="text-red-500 hover:text-red-700"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </div>
                </div>
              </template>
              <div v-else class="text-gray-500 text-center py-4">
                Aucune langue ajoutée
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- Language Modal -->
    <Modal :show="showLanguageModal" @close="closeLanguageModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
          {{ isEditingLanguage ? 'Modifier la langue' : 'Ajouter une langue' }}
        </h2>

        <form @submit.prevent="submitLanguage" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Langue</label>
              <input type="text" v-model="languageForm.name" required
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': languageForm.errors.name }"                
              >
              <InputError v-if="languageForm.errors.name" :message="languageForm.errors.name" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Niveau</label>
              <select v-model="languageForm.level" required
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': languageForm.errors.level }"                
              >
                <option value="">Sélectionnez un niveau</option>
                <option value="Débutant">Débutant</option>
                <option value="Intermédiaire">Intermédiaire</option>
                <option value="Avancé">Avancé</option>
                <option value="Bilingue">Bilingue</option>
                <option value="Langue maternelle">Langue maternelle</option>
              </select>
              <InputError v-if="languageForm.errors.level" :message="languageForm.errors.level" class="mt-1 text-xs text-red-500" />
            </div>
          </div>
          <div class="mt-6 flex justify-end space-x-3">
            <button type="submit"
              class="inline-flex items-center justify-center px-4 py-2 rounded-xs text-white bg-[#2b8d96] hover:bg-[#1a646b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2b8d96]"
            >
              {{ isEditingLanguage ? 'Modifier' : 'Ajouter' }}
            </button>
            <button @click="closeLanguageModal" type="button" class="px-4 py-2 bg-red-500 text-white rounded-xs hover:bg-red-700" >
              Annuler
            </button>
          </div>
        </form>
      </div>
    </Modal>
    <!-- Edit Modal -->
    <Modal :show="showProfilModal" @close="closeProfilModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4"> Modifier mes informations personnelles</h2>
        <form @submit.prevent="updateProfile" class="space-y-4"  enctype="multipart/form-data">

          <div class="grid grid-cols-2 gap-4">            
            <!-- Civility -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Civilité</label>
              <select
                v-model="formProfile.civility"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.civility }"
              >
                <option value="M.">M.</option>
                <option value="Mme">Mme</option>
                <option value="Mlle">Mlle</option>
              </select>
              <InputError v-if="formProfile.errors.civility" :message="formProfile.errors.civility" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Date of Birth -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
              <input
                type="date"
                v-model="formProfile.date_of_birth"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.date_of_birth }"
              >
              <InputError v-if="formProfile.errors.date_of_birth" :message="formProfile.errors.date_of_birth" class="mt-1 text-xs text-red-500" />
            </div>
            <!-- family status -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Statut familial</label>
              <select v-model="formProfile.family_status"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.family_status }" >
                <option value="Célibataire">Célibataire</option>
                <option value="Marié(e)">Marié(e)</option>
                <option value="Divorcé(e)">Divorcé(e)</option>
                <option value="Veuf(ve)">Veuf(ve)</option>
                <option value="Séparé(e)">Séparé(e)</option>
                <option value="Union libre">Union libre</option>
              </select>
              <InputError v-if="formProfile.errors.family_status" :message="formProfile.errors.family_status" class="mt-1 text-xs text-red-500" />
            </div>
            <!-- Profession -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Votre profession</label>
              <input type="text" v-model="formProfile.title"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.title }"
              >
              <InputError v-if="formProfile.errors.phone" :message="formProfile.errors.title" class="mt-1 text-xs text-red-500" />
            </div>
            <!-- Phone -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Téléphone</label>
              <input type="tel" v-model="formProfile.phone"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.phone }"
              >
              <InputError v-if="formProfile.errors.phone" :message="formProfile.errors.phone" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Address -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Adresse</label>
              <input type="text" v-model="formProfile.address"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.address }"
              >
              <InputError v-if="formProfile.errors.address" :message="formProfile.errors.address" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Study Level -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Niveau d'études</label>
              <select v-model="formProfile.study_level"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.study_level }" >
                <option value="Bac">Bac</option>
                <option value="Bac +2">Bac +2</option>
                <option value="Bac +3">Bac +3</option>
                <option value="Bac +4">Bac +4</option>
                <option value="Bac +5">Bac +5</option>
                <option value="Bac +5 et plus">Bac +5 et plus</option>
              </select>
              <InputError v-if="formProfile.errors.study_level" :message="formProfile.errors.study_level" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Nationality -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Nationalité</label>
              <input type="text" v-model="formProfile.nationality"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.nationality }"
              >
              <InputError v-if="formProfile.errors.nationality" :message="formProfile.errors.nationality" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Country -->
            <div>
              <label class="block text-sm font-medium text-gray-700">Pays de résidence</label>
              <input type="text" v-model="formProfile.country"
                class="mt-1 block w-full border-gray-300 shadow-sm focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': formProfile.errors.country }"
              >
              <InputError v-if="formProfile.errors.country" :message="formProfile.errors.country" class="mt-1 text-xs text-red-500" />
            </div>

            <!-- Avatar -->
            <div class="">
              <label class="block text-sm font-medium text-gray-700">Photo de profil</label>
              <input type="file" @input="formProfile.avatar = $event.target.files[0]" accept="image/*"
                class="mt-1 block w-full border border-gray-200 shadow-sm rounded-xs text-sm
                    focus:z-10 focus:border-[#2b8d96] focus:ring-[#2b8d96]
                    disabled:opacity-50 disabled:pointer-events-none  file:me-4 file:py-2.5 file:px-4 "
                :class="{ 'border-red-500': formProfile.errors.avatar }"
              >
              <progress v-if="formProfile.progress" :value="formProfile.progress.percentage" max="100">
                {{ formProfile.progress.percentage }}%
              </progress>
              <InputError v-if="formProfile.errors.avatar" :message="formProfile.errors.avatar" class="mt-2" />
            </div>
            <div class="flex justify-end">
              <img :src="avatarUrl" alt="Avatar" class="size-[52px] object-cover rounded-full mt-4">
            </div>
          </div>

          <div class="mt-6 flex justify-end space-x-3">
            <button type="submit"
              class="inline-flex items-center justify-center px-4 py-2 rounded-xs text-white bg-[#2b8d96] hover:bg-[#1a646b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2b8d96]"
            >
              Enregistrer
            </button>
            <button @click="closeProfilModal" type="button" class="px-4 py-2 bg-red-500 text-white rounded-xs hover:bg-red-700" >
              Annuler
            </button>
          </div>
        </form>
      </div>
    </Modal>
    <!-- Education Modal -->
    <Modal :show="showEducationModal" @close="closeEducationModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
          {{ isEditingEducation ? 'Modifier la formation' : 'Ajouter une formation' }}
        </h2>

        <form @submit.prevent="submitEducation" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Niveau d'étude</label>
              <select v-model="educationForm.level"
                class="w-full p-2 border border-gray-300  focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': educationForm.errors.level }"
              >
                <option value="Bac +5 et plus">Bac +5 et plus</option>
                <option value="Bac +3">Bac +3</option>
                <option value="Bac +2">Bac +2</option>
                <option value="Bac">Bac</option>
              </select>
              <InputError v-if="educationForm.errors.level" :message="educationForm.errors.level" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Type d'établissement</label>
              <select v-model="educationForm.type"
                class="w-full p-2 border border-gray-300  focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': educationForm.errors.type }"
              >
                <option value="Université">Université</option>
                <option value="École d'ingénieur">École d'ingénieur</option>
                <option value="École de commerce">École de commerce</option>
              </select>
              <InputError v-if="educationForm.errors.type" :message="educationForm.errors.type" class="mt-1 text-xs text-red-500" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <InputLabel for="education_city" value="Ville" />
              <TextInput id="education_city" type="text" class="mt-1 block w-full" v-model="educationForm.city"
                :class="{ 'border-red-500': educationForm.errors.city }"
              />
              <InputError v-if="educationForm.errors.city" :message="educationForm.errors.city" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
              <InputLabel for="education_country" value="Pays" />
              <TextInput id="education_country" type="text" class="mt-1 block w-full" v-model="educationForm.country"
                :class="{ 'border-red-500': educationForm.errors.country }"
              />
              <InputError v-if="educationForm.errors.country" :message="educationForm.errors.country" class="mt-1 text-xs text-red-500" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
              <input v-model="educationForm.start_date" type="date"
                class="w-full p-2 border border-gray-300  focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': educationForm.errors.start_date }"
              />
              <InputError v-if="educationForm.errors.start_date" :message="educationForm.errors.start_date" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
              <input v-model="educationForm.end_date" type="date"
                class="w-full p-2 border border-gray-300  focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': educationForm.errors.end_date }"
              />
              <InputError v-if="educationForm.errors.end_date" :message="educationForm.errors.end_date" class="mt-1 text-xs text-red-500" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Établissement</label>
            <input v-model="educationForm.school" type="text"
              class="w-full p-2 border border-gray-300  focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              :class="{ 'border-red-500': educationForm.errors.school }"
            />
            <InputError v-if="educationForm.errors.school" :message="educationForm.errors.school" class="mt-1 text-xs text-red-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Diplôme</label>
            <input v-model="educationForm.diploma" type="text"
              class="w-full p-2 border border-gray-300  focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              :class="{ 'border-red-500': educationForm.errors.diploma }"
            />
            <InputError v-if="educationForm.errors.diploma" :message="educationForm.errors.diploma" class="mt-1 text-xs text-red-500" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea v-model="educationForm.description"
              class="w-full h-40 p-2 border border-gray-300  focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              :class="{ 'border-red-500': educationForm.errors.description }"
            />
            <InputError v-if="educationForm.errors.description" :message="educationForm.errors.description" class="mt-1 text-xs text-red-500" />
          </div>

          <div class="flex justify-end space-x-4">
            <button @click="correctSummary(educationForm.description,'education')"
              :disabled="educationForm.processing || !educationForm.description?.trim()"
              class="px-6 py-2 bg-[#2b8d96] text-white hover:bg-[#1a526a] disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{ isLoading ? 'Correction en cours...' : 'Corriger avec HOKOUI-EMPLOI' }}
            </button>
            <button class="px-6 py-2 bg-secondary text-white hover:bg-yellow-700" :disabled="educationForm.processing" >
              {{ isEditingEducation ? 'Modifier' : 'Ajouter' }}
            </button>
            <button type="button" @click="closeEducationModal" class="px-6 py-2 bg-danger text-white hover:bg-red-700" >
              Annuler
            </button>
          </div>
        </form>
      </div>
    </Modal>
    <!-- Experience Modal -->
    <Modal :show="showExperienceModal" @close="closeExperienceModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
          {{ isEditingExperience ? "Modifier l'expérience" : "Ajouter une expérience" }}
        </h2>

        <form @submit.prevent="submitExperience" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Titre du poste</label>
              <input v-model="experienceForm.title" type="text"
                class="w-full p-2 border border-gray-300 focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': experienceForm.errors.title }"
              />
              <InputError v-if="experienceForm.errors.title" :message="experienceForm.errors.title" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise</label>
              <input v-model="experienceForm.company" type="text"
                class="w-full p-2 border border-gray-300 focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': experienceForm.errors.company }"
              />
              <InputError v-if="experienceForm.errors.company" :message="experienceForm.errors.company" class="mt-1 text-xs text-red-500" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Lieu</label>
            <input v-model="experienceForm.location" type="text"
              class="w-full p-2 border border-gray-300 focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              :class="{ 'border-red-500': experienceForm.errors.location }"
            />
            <InputError v-if="experienceForm.errors.location" :message="experienceForm.errors.location" class="mt-1 text-xs text-red-500" />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <InputLabel for="experience_city" value="Ville" />
              <TextInput id="experience_city" type="text" class="mt-1 block w-full" v-model="experienceForm.city" 
                :class="{ 'border-red-500': experienceForm.errors.city }" 
              />
              <InputError v-if="experienceForm.errors.city" :message="experienceForm.errors.city" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
              <InputLabel for="experience_country" value="Pays" />
              <TextInput id="experience_country" type="text" class="mt-1 block w-full" v-model="experienceForm.country" :class="{ 'border-red-500': experienceForm.errors.country }" />
              <InputError v-if="experienceForm.errors.country" :message="experienceForm.errors.country" class="mt-1 text-xs text-red-500" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
              <input v-model="experienceForm.start_date" type="date" class="w-full p-2 border border-gray-300 focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': experienceForm.errors.start_date }"
              />
              <InputError v-if="experienceForm.errors.start_date" :message="experienceForm.errors.start_date" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
              <input v-model="experienceForm.end_date" type="date" class="w-full p-2 border border-gray-300 focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                :class="{ 'border-red-500': experienceForm.errors.end_date }"
              />
              <InputError v-if="experienceForm.errors.end_date" :message="experienceForm.errors.end_date" class="mt-1 text-xs text-red-500" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea v-model="experienceForm.description"
              class="w-full h-40 p-2 border border-gray-300 focus:border-[#2b8d96] focus:ring-[#2b8d96]"
              :class="{ 'border-red-500': experienceForm.errors.description }"
            />
            <InputError v-if="experienceForm.errors.description" :message="experienceForm.errors.description" class="mt-1 text-xs text-red-500" />
          </div>

          <div class="flex justify-end space-x-4">
            <button @click="correctSummary(experienceForm.description,'experience')"
              :disabled="isLoading || !experienceForm.description?.trim() || experienceForm.processing"
              class="px-6 py-2 bg-[#2b8d96] text-white hover:bg-[#1a526a] disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ isLoading ? 'Correction en cours...' : 'Corriger avec HOKOUI-EMPLOI' }}
            </button>
            <button type="submit" class="px-6 py-2 bg-secondary text-white hover:bg-yellow-700" 
             :disabled="isLoading || experienceForm.processing" 
            >
              {{ isEditingExperience ? 'Modifier' : 'Ajouter' }}
            </button>
            <button type="button" @click="closeExperienceModal" class="px-6 py-2 bg-danger text-white hover:bg-red-700" 
              :disabled="isLoading || experienceForm.processing" 
            >
              Annuler
            </button>
          </div>
        </form>
      </div>
    </Modal>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Modal from '@/Components/Modal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import { confirmDelete } from "@/utils/useConfirm";
import { showToast } from '@/Utils/useToast'
import { formatDateForInput, formatSortedDate, formattedNormalDate } from '@/Utils/useDate'

const defaultAvatar = '/storage/default-avatar.png';

const props = defineProps({
  auth: Object,
  errors: Object,
  userInfo: Object,
})


// Profil state
const showProfilModal = ref(false)
const formProfile = useForm({
  civility: props.userInfo?.civility || '',
  title: props.userInfo?.title || '',
  date_of_birth: props.userInfo?.date_of_birth || '',
  family_status: props.userInfo?.family_status || '',
  phone: props.userInfo?.phone || '',
  address: props.userInfo?.address || '',
  nationality: props.userInfo?.nationality || '',
  study_level: props.userInfo?.study_level || '',
  country: props.userInfo?.country || '',
  avatar: null
})

// Summary state
const isEditingSummary = ref(false);
const formSummary = useForm({
  resume: props.userInfo?.summary || '',
})

// Language state
const showLanguageModal = ref(false)
const editingLanguageId = ref(null);
const isEditingLanguage = ref(false)
const languageForm = useForm({
  name: '',
  level: ''
});

// Education state
const showEducationModal = ref(false)
const isEditingEducation = ref(false)
const editingEducationId = ref(null)
// Experience state
const isEditingExperience = ref(false)
const editingExperienceId = ref(null)
const showExperienceModal = ref(false)

const colorSetting = ref('primary')
const formErrors = ref({});
const isLoading = ref(false)

const downloadPDF = async () => {
  try {
    isLoading.value = true;
    const { data } = await axios.get(route('curriculum.pdf', {
      id: props.auth.user.id, 
      color: colorSetting.value 
    }), {
      responseType: 'blob' 
    });

    const url = URL.createObjectURL(new Blob([data], { type: 'application/pdf' }));
    const link = document.createElement('a')
    link.href = url
    link.download = 'cv.pdf';
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    URL.revokeObjectURL(url)
    isLoading.value = false;
  } catch (error) {
    console.error('Error downloading PDF:', error)
    showToast("error", "Une erreur est survenue lors du téléchargement du PDF !");
    isLoading.value = false;
  }
}
function closeProfilModal() {
  showProfilModal.value = false
}

const updateProfile = async () => {
  formProfile.post(route('curriculum.profile.update'), {
    preserveScroll: true,
    onSuccess: () => {
      showToast("success", "Profil mis à jour avec succès !");
      showProfilModal.value = false
    },
    onError: (errors) => {
      console.error('Error updating profile:', errors)
    }
  })
    
};

const educationForm = useForm({
  level: '',
  type: '',
  status: 'valider',
  start_date: '',
  end_date: '',
  school: '',
  diploma: '',
  description: '',
  city: '',
  country: ''
})

const submitEducation = () => {
  if (isEditingEducation.value) {
    educationForm.put(route('education.update', editingEducationId.value), {
      preserveScroll: true,
      onSuccess: () => {
        showToast("success", "Formation modifiée avec succès !");
        showEducationModal.value = false;
        closeEducationModal();
      },
      onError: (errors) => {
        console.error('Error updating education:', errors)
      }
    });
  } else {
    educationForm.post(route('education.store'), {
      preserveScroll: true,
      onSuccess: () => {
        showToast("success", "Formation ajoutée avec succès !");
        showEducationModal.value = false;
        closeEducationModal();
      }
    });
  }
}
const editEducation = (education) => {
 educationForm.level = education.level;
  educationForm.type = education.type;
  educationForm.start_date = formatDateForInput(education.start_date);
  educationForm.end_date = formatDateForInput(education.end_date);
  educationForm.school = education.school;
  educationForm.diploma = education.diploma;
  educationForm.description = education.description;
  educationForm.city = education.city;
  educationForm.country = education.country;

  isEditingEducation.value = true
  editingEducationId.value = education.id
  showEducationModal.value = true
}
const closeEducationModal = () => {
  showEducationModal.value = false
  isEditingEducation.value = false
  editingEducationId.value = null
  educationForm.reset();
}

const deleteEducation = async (id) => {
  if (!await confirmDelete()) return;
  router.delete(route('education.destroy', id), {
    preserveScroll: true,
    onSuccess: () => {
      showToast("success", "Supprimer avec succès !");
    },
    onError: (errors) => {
      console.error('Error deleting education:', errors)
    }
  })

}

const submitLanguage = async () => {
  if (isEditingLanguage.value) {
    // Update existing language
    languageForm.put(route('curriculum.language.update', editingLanguageId.value), {
      preserveScroll: true,
      onSuccess: () => {
        showToast("success", "Langue modifiée avec succès !");
        closeLanguageModal();
      },
      onError: (errors) => {
        console.error('Error updating language:', errors)
      }
    });
    
  } else {
    // Add new language
    languageForm.post(route('curriculum.language.add'), {
      preserveScroll: true,
      onSuccess: () => {
        showToast("success", "Langue ajoutée avec succès !");
        closeLanguageModal();
      },
      onError: (errors) => {
        console.error('Error adding language:', errors)
      }
    });      
  }  
};

const editLanguage = (language) => {
  editingLanguageId.value = language.id;
  languageForm.name = language.name;
  languageForm.level = language.level;
  isEditingLanguage.value = true;
  showLanguageModal.value = true;
};

const deleteLanguage = async (id) => {
  if (!await confirmDelete()) return;
  router.delete(route('curriculum.language.delete', id), {
    preserveScroll: true,
    onSuccess: () => {
      showToast("success", "Supprimer avec succès !");
    },
    onError: (errors) => {
      console.error('Error deleting language:', errors)
    }
  })
};

function closeLanguageModal() {
  showLanguageModal.value = false
  languageForm.reset();
  isEditingLanguage.value = false;
  editingLanguageId.value = null;
}

const toggleSummaryEdit = () => {
  isEditingSummary.value = !isEditingSummary.value
}

const validateSummary = () => {
  formSummary.post(route('curriculum.resume.update'), {
    preserveScroll: true,
    onSuccess: () => {
      isEditingSummary.value = false
      showToast("success", "Résumé mis à jour avec succès !");
    },
    onError: (errors) => {
      console.error('Error updating resume:', errors)
      showToast("error", "Une erreur est survenue lors de la mise à jour du résumé !");
    }
  })
}

const correctSummary = async (summaryToEdit,category = null) => {
  if (!summaryToEdit.trim()) return
  formErrors.value = {}
  isLoading.value = true

  try {
    const { data } = await axios.post(route('curriculum.resume.correct'), {
      resume: summaryToEdit,
      category: category
    });

    if (data.success) {
      const correctedResume = data.resume;
      if (category === 'education') {
        educationForm.description = correctedResume
      } else if (category === 'experience') {
        experienceForm.description = correctedResume
      } else {
        formSummary.resume = correctedResume
      }
      showToast("success", "Corrigé avec succès !");
    }
  } catch (error) {
    if (error.response?.data?.errors) {
      formErrors.value = error.response.data.errors;
    }
    console.error('Error correcting resume:', error)
    showToast("error", "Une erreur est survenue lors de la correction du résumé !");
  } finally {
    isLoading.value = false
  }
}

const experienceForm = useForm({
  title: '',
  company: '',
  location: '',
  start_date: '',
  end_date: '',
  description: '',
  city: '',
  country: ''
})

const submitExperience = async () => { 
  if (isEditingExperience.value) {
    experienceForm.put(route('experience.update', editingExperienceId.value), {
      preserveScroll: true,
      onSuccess: () => {
        showToast("success", "Expérience modifiée avec succès !");
        showExperienceModal.value = false;
        closeExperienceModal();
      }
    });
  } else {
    experienceForm.post(route('experience.store'), {
      preserveScroll: true,
      onSuccess: () => {
        showToast("success", "Expérience ajoutée avec succès !");
        showExperienceModal.value = false;
        closeExperienceModal();
      }
    });
  }
}

const editExperience = (experience) => {
  experienceForm.title = experience.title
  experienceForm.company = experience.company
  experienceForm.location = experience.location
  experienceForm.start_date = formatDateForInput(experience.start_date)
  experienceForm.end_date = formatDateForInput(experience.end_date)
  experienceForm.description = experience.description
  experienceForm.city = experience.city
  experienceForm.country = experience.country

  isEditingExperience.value = true
  editingExperienceId.value = experience.id
  showExperienceModal.value = true
}

const deleteExperience = async (id) => {
  if (!await confirmDelete()) return;
  router.delete(route('experience.destroy', id), {
    preserveScroll: true,
    onSuccess: () => {
      showToast("success", "Supprimer avec succès !");
    },
    onError: (errors) => {
      console.error('Error deleting experience:', errors)
    }
  })
}

const closeExperienceModal = () => {
  showExperienceModal.value = false
  isEditingExperience.value = false
  editingExperienceId.value = null
  experienceForm.reset();
}



const avatarUrl = computed(() => {
  if (props.userInfo.avatar) {
    return `/storage/${props.userInfo.avatar}`
  }
  if (props.auth?.user?.profile_photo_url) {
    return props.auth.user.profile_photo_url
  }
  return defaultAvatar
})

</script>
