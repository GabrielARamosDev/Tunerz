import React, { useState, useEffect } from 'react';

import api from '../../services/api';

import {
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    Button,
    Stack,
    Select,
    MenuItem,
    InputLabel,
    FormControl,
    CircularProgress,
} from '@mui/material';

import type { Vehicle } from '../../types/vehicle';

interface AddVehicleDialogProps {
    open: boolean;
    onClose: () => void;
    onAddVehicle: (vehicle: Vehicle) => void;
}

const AddVehicleDialog = ({ open, onClose, onAddVehicle }: AddVehicleDialogProps) => {

    const [formData, setFormData] = useState({
        manufacturer: '',
        model: '',
        trim: '',
        year: new Date().getFullYear(),
        generation: 0,
    });

    const [options, setOptions] = useState({
        manufacturers: [] as string[],
        models: [] as string[],
        trims: [] as string[],
        years: [] as number[],
        generations: [] as number[],
    });

    const [loading, setLoading] = useState({
        manufacturers: false,
        models: false,
        trims: false,
        years: false,
        generations: false,
    });

    /* ============================================================== */

    // Fetch manufacturers on dialog open
    useEffect(() => {
        if (open) {
            fetchManufacturers();
        }
    }, [open]);

    // Fetch models when manufacturer changes
    useEffect(() => {
        if (formData.manufacturer) {
            fetchModels();
        } else {
            setOptions(prev => ({ ...prev, models: [], trims: [] }));
            setFormData(prev => ({ ...prev, model: '', trim: '' }));
        }
    }, [formData.manufacturer]);

    // Fetch trims when model changes
    useEffect(() => {
        if (formData.model && formData.manufacturer) {
            fetchTrims();
        } else {
            setOptions(prev => ({ ...prev, trims: [] }));
            setFormData(prev => ({ ...prev, trim: '' }));
        }
    }, [formData.model, formData.manufacturer]);

    useEffect(() => {
        if (formData.trim && formData.model && formData.manufacturer) {
            fetchYears();
        } else {
            setOptions(prev => ({ ...prev, years: [] }));
            setFormData(prev => ({ ...prev, year: new Date().getFullYear() }));
        }
    }, [formData.trim, formData.model, formData.manufacturer]);

    useEffect(() => {
        if (formData.trim && formData.model && formData.manufacturer) {
            fetchGenerations();
        } else {
            setOptions(prev => ({ ...prev, generations: [] }));
            setFormData(prev => ({ ...prev, generation: 0 }));
        }
    }, [formData.year, formData.trim, formData.model, formData.manufacturer]);

    /* ============================================================== */

    const fetchManufacturers = async () => {
        try {
            setLoading(prev => ({ ...prev, manufacturers: true }));
            const response = await api.get('/vehicles/options/manufacturers');
            setOptions(prev => ({ ...prev, manufacturers: response.data }));
        } catch (error) {
            console.error('Erro ao carregar fabricantes:', error);
        } finally {
            setLoading(prev => ({ ...prev, manufacturers: false }));
        }
    };

    const fetchModels = async () => {
        try {
            setLoading(prev => ({ ...prev, models: true }));
            const response = await api.get('/vehicles/options/models', {
                params: { manufacturer: formData.manufacturer },
            });
            setOptions(prev => ({ ...prev, models: response.data }));
        } catch (error) {
            console.error('Erro ao carregar modelos:', error);
        } finally {
            setLoading(prev => ({ ...prev, models: false }));
        }
    };

    const fetchTrims = async () => {
        try {
            setLoading(prev => ({ ...prev, trims: true }));
            const response = await api.get('/vehicles/options/trims', {
                params: {
                    manufacturer: formData.manufacturer,
                    model: formData.model,
                },
            });
            setOptions(prev => ({ ...prev, trims: response.data }));
        } catch (error) {
            console.error('Erro ao carregar versões:', error);
        } finally {
            setLoading(prev => ({ ...prev, trims: false }));
        }
    };

    const fetchYears = async () => {
        try {
            setLoading(prev => ({ ...prev, years: true }));
            const response = await api.get('/vehicles/options/years', {
                params: {
                    manufacturer: formData.manufacturer,
                    model: formData.model,
                    trim: formData.trim,
                },
            });
            setOptions(prev => ({ ...prev, years: response.data }));
        } catch (error) {
            console.error('Erro ao carregar anos:', error);
        } finally {
            setLoading(prev => ({ ...prev, years: false }));
        }
    };

    const fetchGenerations = async () => {
        try {
            setLoading(prev => ({ ...prev, generations: true }));
            const response = await api.get('/vehicles/options/generations', {
                params: {
                    manufacturer: formData.manufacturer,
                    model: formData.model,
                    trim: formData.trim,
                    year: formData.year,
                },
            });
            setOptions(prev => ({ ...prev, generations: response.data }));
        } catch (error) {
            console.error('Erro ao carregar anos:', error);
        } finally {
            setLoading(prev => ({ ...prev, generations: false }));
        }
    };

    /* * */

    const handleInputChange = (e: React.ChangeEvent<{ name?: string; value: unknown }>) => {
        const { name, value } = e.target as { name: string; value: unknown };
        setFormData(prev => ({
            ...prev,
            [name]: name === 'year' ? parseInt(value as string) : value,
        }));
    };

    const handleSubmit = () => {
        if (!formData.manufacturer || !formData.model || !formData.trim) {
            alert('Por favor, preencha todos os campos obrigatórios');
            return;
        }

        onAddVehicle({
            manufacturer: formData.manufacturer,
            model: formData.model,
            trim: formData.trim,
            year: formData.year,
            generation: formData.generation, 
        } as Vehicle);

        setFormData({
            manufacturer: '',
            model: '',
            trim: '',
            year: new Date().getFullYear(),
            generation: 0,
        });
        onClose();
    };

    /* ============================================================== */

    return (
        <Dialog open={open} onClose={onClose} maxWidth="sm" fullWidth>
            <DialogTitle>Adicionar Novo Veículo</DialogTitle>
            <DialogContent>
                <Stack spacing={2} sx={{ mt: 2 }}>
                    <FormControl fullWidth>
                        <InputLabel>Fabricante</InputLabel>
                        <Select
                            name="manufacturer"
                            label="Fabricante"
                            value={formData.manufacturer}
                            onChange={handleInputChange}
                            disabled={loading.manufacturers}
                        >
                            <MenuItem value="">
                                {loading.manufacturers ? <CircularProgress size={20} /> : 'Selecione'}
                            </MenuItem>
                            {options.manufacturers.map((manufacturer) => (
                                <MenuItem key={manufacturer} value={manufacturer}>
                                    {manufacturer}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>

                    <FormControl fullWidth disabled={!formData.manufacturer || loading.models}>
                        <InputLabel>Modelo</InputLabel>
                        <Select
                            name="model"
                            label="Modelo"
                            value={formData.model}
                            onChange={handleInputChange}
                        >
                            <MenuItem value="">
                                {loading.models ? <CircularProgress size={20} /> : 'Selecione'}
                            </MenuItem>
                            {options.models.map((model) => (
                                <MenuItem key={model} value={model}>
                                    {model}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>

                    <FormControl fullWidth disabled={!formData.model || loading.trims}>
                        <InputLabel>Versão</InputLabel>
                        <Select
                            name="trim"
                            label="Versão"
                            value={formData.trim}
                            onChange={handleInputChange}
                        >
                            <MenuItem value="">
                                {loading.trims ? <CircularProgress size={20} /> : 'Selecione'}
                            </MenuItem>
                            {options.trims.map((trim) => (
                                <MenuItem key={trim} value={trim}>
                                    {trim}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>

                    <FormControl fullWidth disabled={!formData.trim || loading.years}>
                        <InputLabel>Ano</InputLabel>
                        <Select
                            name="year"
                            label="Ano"
                            value={formData.year}
                            onChange={handleInputChange}
                        >
                            <MenuItem value="">
                                {loading.years ? <CircularProgress size={20} /> : 'Selecione'}
                            </MenuItem>
                            {options.years.map((year) => (
                                <MenuItem key={year} value={year}>
                                    {year}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>

                    <FormControl fullWidth disabled={!formData.trim || loading.generations}>
                        <InputLabel>Geração</InputLabel>
                        <Select
                            name="generation"
                            label="Geração"
                            value={formData.generation}
                            onChange={handleInputChange}
                        >
                            <MenuItem value="">
                                {loading.generations ? <CircularProgress size={20} /> : 'Selecione'}
                            </MenuItem>
                            {options.generations.map((generation) => (
                                <MenuItem key={generation} value={generation}>
                                    {generation}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                </Stack>
            </DialogContent>
            <DialogActions>
                <Button onClick={onClose}>Cancelar</Button>
                <Button onClick={handleSubmit} variant="contained">
                    Adicionar
                </Button>
            </DialogActions>
        </Dialog>
    );
};

export default AddVehicleDialog;
