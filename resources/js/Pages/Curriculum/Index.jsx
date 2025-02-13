import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import defaultAvatar from '@/Images/profil.jpg';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import axios from 'axios';

export default function Index({ profileNumber, userInfo, auth }) {
    const [summary, setSummary] = useState(userInfo.summary || '');
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState('');

    const handleCorrection = async () => {
        if (!summary.trim()) return;

        setIsLoading(true);
        setError('');
        
        try {
            const response = await axios.post(route('curriculum.correct-summary'), {
                summary: summary
            });
            
            if (response.data.success) {
                setSummary(response.data.summary);
            } else {
                setError(response.data.message || 'Une erreur est survenue lors de la correction');
            }
        } catch (error) {
            setError(error.response?.data?.message || 'Une erreur est survenue lors de la correction');
            console.error('Erreur lors de la correction:', error);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Ajouter une expérience</h2>}
        >
            <Head title="Mon CV " />
            
            <div className="min-h-screen bg-gray-100 py-6">
                <div className="max-w-4xl mx-auto">
                    <div className="bg-white rounded-lg shadow-lg overflow-hidden">
                        {/* Header */}
                        <div className="p-6">
                            <div className="flex justify-between items-start">
                                <h1 className="text-2xl font-bold text-[#2b8d96]">Mon CV </h1>
                                <button className="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded">
                                    Modifier
                                </button>
                            </div>
                            {/* <div className="text-sm text-gray-500">N° du profil : {profileNumber}</div> */}
                        </div>

                        {/* Profile Section */}
                        <div className="px-6 py-4 border-t border-gray-200">
                            <div className="flex space-x-6">
                                <div className="w-32">
                                    <img
                                        src={defaultAvatar}
                                        alt="Profile"
                                        className="w-full h-32 object-cover rounded-lg bg-gray-200"
                                    />
                                </div>
                                <div className="flex-1">
                                    <h2 className="text-xl font-semibold text-gray-700">{userInfo.name}</h2>
                                    <p className="text-gray-600">{userInfo.title}</p>
                                    <div className="mt-2">
                                        <p className="text-sm text-gray-500">
                                            {userInfo.categories.join(' / ')}
                                        </p>
                                    </div>
                                    
                                    <div className="mt-4 grid grid-cols-2 gap-4">
                                        <div>
                                            <p className="text-sm">
                                                <span className="text-gray-500">Date de naissance :</span>
                                                <span className="ml-2">{userInfo.birthDate}</span>
                                            </p>
                                            <p className="text-sm">
                                                <span className="text-gray-500">Nationalité :</span>
                                                <span className="ml-2">{userInfo.nationality}</span>
                                            </p>
                                            <p className="text-sm">
                                                <span className="text-gray-500">Situation familiale :</span>
                                                <span className="ml-2">{userInfo.familyStatus}</span>
                                            </p>
                                            <p className="text-sm">
                                                <span className="text-gray-500">Niveau d'étude :</span>
                                                <span className="ml-2">{userInfo.educationLevel}</span>
                                            </p>
                                        </div>
                                        <div>
                                            <p className="text-sm">
                                                <span className="text-gray-500">Adresse :</span>
                                                <span className="ml-2">{userInfo.address}</span>
                                            </p>
                                            <p className="text-sm">
                                                <span className="text-gray-500">Téléphone :</span>
                                                <span className="ml-2">{userInfo.phone}</span>
                                            </p>
                                            <p className="text-sm">
                                                <span className="text-gray-500">E-mail :</span>
                                                <span className="ml-2">{userInfo.email}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Action Buttons */}
                        <div className="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div className="flex space-x-4">
                                <button className="flex items-center text-[#2b8d96] hover:text-pink-600">
                                    <svg className="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clipRule="evenodd" />
                                    </svg>
                                    Version PDF
                                </button>
                                <button className="flex items-center text-[#2b8d96] hover:text-pink-600">
                                    <svg className="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    Envoyer ce CV par mail
                                </button>
                                <button className="flex items-center text-[#2b8d96] hover:text-pink-600">
                                    <svg className="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 014 16a5.986 5.986 0 004.546-2.084A5 5 0 0014 10z" clipRule="evenodd" />
                                    </svg>
                                    Version Web
                                </button>
                            </div>
                        </div>

                        {/* Resume Section */}
                        <div className="p-6 border-t border-gray-200">
                            <div className="flex items-center mb-4">
                                <div className="h-4 w-1 bg-[#2b8d96] mr-2"></div>
                                <h3 className="text-lg font-semibold">Résumé de mon CV</h3>
                            </div>
                            
                            {/* Kiara Section */}
                            <div className="mt-6 bg-[#2b8d96] rounded-lg overflow-hidden">
                                <div className="p-6 text-white flex justify-between items-center">
                                    <div>
                                        <h2 className="text-3xl font-bold mb-2">Quelques secondes pour convaincre.</h2>
                                        <p className="text-lg">Générez un résumé de CV percutant grâce à GEO-IA.</p>
                                    </div>
                                    <div className="text-4xl font-bold text-[#1a526a]">
                                        GEO<span className="text-yellow-400">AI</span>
                                    </div>
                                </div>
                                
                                <div className="bg-white p-6">
                                    <p className="text-gray-600 text-sm italic mb-4">
                                        Rédigez ci-dessous un résumé de votre carrière et de vos aspirations professionnelles. 
                                        GEO-AI peut vous faire ici un résumé sur la base de votre CV joint.
                                        Êtes-vous prêt à utiliser la puissance de l'IA ?!
                                    </p>
                                    
                                    <textarea
                                        value={summary}
                                        onChange={(e) => setSummary(e.target.value)}
                                        className="w-full h-40 p-4 border border-gray-300 rounded-lg focus:border-[#2b8d96] focus:ring-[#2b8d96]"
                                        placeholder="Écrivez votre résumé ici..."
                                    />
                                    {error && <div className="mt-2 text-red-500">{error}</div>}
                                    
                                    <div className="mt-4 flex justify-end space-x-4">
                                        <button
                                            onClick={handleCorrection}
                                            disabled={isLoading || !summary.trim()}
                                            className="relative px-6 py-2 bg-[#2b8d96] text-white rounded hover:bg-[#247a82] disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            {isLoading ? (
                                                <>
                                                    <span className="opacity-0">Corriger</span>
                                                    <div className="absolute inset-0 flex items-center justify-center">
                                                        <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                    </div>
                                                </>
                                            ) : (
                                                'Corriger'
                                            )}
                                        </button>
                                        <button
                                            onClick={() => setSummary('')}
                                            disabled={isLoading || !summary.trim()}
                                            className="px-6 py-2 border border-[#2b8d96] text-[#2b8d96] rounded hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
