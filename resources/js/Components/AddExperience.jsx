import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import axios from 'axios';

export default function AddExperience() {
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState('');
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        startDate: '',
        endDate: new Date().toISOString().split('T')[0],
        description: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('experience.store'), {
            onSuccess: () => {
                reset();
            }
        });
    };

    const handleCorrection = async () => {
        if (!data.description.trim()) return;

        setIsLoading(true);
        setError('');
        
        try {
            const response = await axios.post(route('experience.correct-description'), {
                description: data.description
            });
            
            if (response.data.success) {
                setData('description', response.data.description);
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
        <div className="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form onSubmit={handleSubmit} className="space-y-6">
                <div>
                    <InputLabel htmlFor="title" value="Titre" />
                    <TextInput
                        id="title"
                        type="text"
                        name="title"
                        value={data.title}
                        className="mt-1 block w-full"
                        onChange={e => setData('title', e.target.value)}
                        required
                    />
                    {errors.title && <div className="text-red-500">{errors.title}</div>}
                </div>

                <div>
                    <InputLabel htmlFor="startDate" value="Date de début" />
                    <TextInput
                        id="startDate"
                        type="date"
                        name="startDate"
                        value={data.startDate}
                        className="mt-1 block w-full"
                        onChange={e => setData('startDate', e.target.value)}
                        required
                    />
                    {errors.startDate && <div className="text-red-500">{errors.startDate}</div>}
                </div>

                <div>
                    <InputLabel htmlFor="endDate" value="Date de fin" />
                    <TextInput
                        id="endDate"
                        type="date"
                        name="endDate"
                        value={data.endDate}
                        className="mt-1 block w-full"
                        onChange={e => setData('endDate', e.target.value)}
                        required
                    />
                    {errors.endDate && <div className="text-red-500">{errors.endDate}</div>}
                </div>

                <div>
                    <InputLabel htmlFor="description" value="Description" />
                    <textarea
                        id="description"
                        name="description"
                        value={data.description}
                        onChange={e => setData('description', e.target.value)}
                        required
                        className="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        rows="4"
                    />
                    {errors.description && <div className="text-red-500">{errors.description}</div>}
                    {error && <div className="mt-2 text-red-500">{error}</div>}
                </div>

                <div className="flex items-center justify-end space-x-4">
                    <SecondaryButton
                        type="button"
                        onClick={handleCorrection}
                        disabled={isLoading || !data.description.trim()}
                        className="relative"
                    >
                        {isLoading ? (
                            <>
                                <span className="opacity-0">Corriger</span>
                                <div className="absolute inset-0 flex items-center justify-center">
                                    <svg className="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </>
                        ) : (
                            'Corriger'
                        )}
                    </SecondaryButton>
                    <PrimaryButton type="submit" disabled={processing || isLoading}>
                        Valider
                    </PrimaryButton>
                </div>
            </form>
        </div>
    );
}
