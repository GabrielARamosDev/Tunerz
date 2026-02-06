
import _ from 'lodash';

import axios from 'axios';
import React from 'react';

import Chip from '@mui/material/Chip';

import notifications from '../controllers/notifications';

import type { BaseModel, FormFields, Attributes as ModelAttributes, TableHead } from '../types/basemodel';

class Model {

    #id = null;
    #attributes: ModelAttributes = {};
    #created_at = null;
    #updated_at = null;
    #resourceKey: string = '';

    constructor(props: BaseModel, resourceKey: string) {

        const {
            id,
            created_at,
            updated_at,
            ...attributes
        } = props;

        this.#id = id;
        this.#resourceKey = resourceKey;

        this.#attributes = attributes;
        this.#created_at = created_at;
        this.#updated_at = updated_at;
    }

    setAttributes = (attributes: ModelAttributes) => {
        this.#attributes = attributes;
    };

    #checkIfDataHasChanged = (attributes: ModelAttributes) => !_.isEqual(attributes, this.#attributes);

    useData = (options: { debug?: boolean, serialize?: boolean } = {}) => {

        const [attributes, setAttributes] = React.useState(this.#attributes);

        if (options.debug) {
            console.log('Item data: ', attributes);
        }
        if (options.serialize) {
            setAttributes(attributes.serialize());
        }

        return {
            data: attributes,
            setData: setAttributes,
            setProp: (key: string, value: any) => setAttributes({
                ...attributes,
                [key]: value,
            }),
            save: async () => {
                try {
                    console.log(`save the item ${this.resourceKey}`, attributes);

                    const url = `/api/${this.getApiLink()}${this.id != 0 ? `/${this.id}` : ''}`;

                    // eslint-disable-next-line no-unused-vars
                    const response = await axios({
                        url,
                        method: 'POST',
                        data: attributes,
                    });
                    // console.log(response);
                    if (response.status === 200) {
                        notifications.create('Dados salvos com sucesso!', 'success');

                        this.setAttributes(attributes);

                        return true;
                    }
                } catch (error: any) {
                    if (error.response?.status === 422) {
                        const errors = Object.keys(error.response.data.errors);

                        notifications.error(`Os dados informados são inválidos: \n${
                            errors.map((field) => `${field}: ${error.response.data.errors[
                                field
                            ].join(' ')} \n`)}`);
                        console.log(errors);
                        console.log(error.response.data.errors);
                    }
                }
                return false;
            },
            isDirty: this.#checkIfDataHasChanged(attributes),
        };
    };

    delete = async () => {
        try {
            console.log(`delete the item ${this.resourceKey}`);

            const url = `/api/${this.getApiLink()}/${this.id}`;

            // eslint-disable-next-line no-unused-vars
            const response = await axios({
                url,
                method: 'DELETE',
            });
            // console.log(response);
            if (response.status === 200) {
                notifications.create('Dado deletado com sucesso!', 'success');
                return true;
            }
        } catch (error: any) {
            if (error.response?.status === 422) {
                const errors = Object.keys(error.response.data.errors);

                notifications.error(`O item informado é inválido: \n${
                    errors.map((field) => `${field}: ${error.response.data.errors[
                        field
                    ].join(' ')} \n`)}`);
                console.log(errors);
                console.log(error.response.data.errors);
            }
        }
        return false;
    };

    serialize = (): object => ({
        ...this.attributes,
        id: this.id,
        created_at: this.#created_at,
        updated_at: this.#updated_at,
    });

    get original() {
        return this.#attributes;
    }

    get attributes() {
        return this.#attributes;
    }

    get id() {
        return this.#id;
    }

    get resourceKey() {
        return this.#resourceKey;
    }

    get createdAt() {
        return this.#created_at;
    }

    get updatedAt() {
        return this.#updated_at;
    }

    getApiLink = () => `app/${this.#resourceKey}`;

    getLink = () => `/${this.#resourceKey}/${this.#id}`;

    static getFormFields = (args: FormFields): any[] => [];

    static getTableActions = (args: FormFields): any[] => [];

    /**
     * Retorna o nome de cada coluna p/ o TableHead.
     *
     * O valor pode ser 'string' ou um 'object' no formato: { name: '', ...other },
     * onde caso o other receba um 'sx' definindo a 'width' da célula, o cálculo deve
     * ser efetuado da seguinte forma: "wd_1 + wd_2 + ... wd_n + (3.75 * tableAction.length) + 7.5 = 100%",
     * onde o último valor '7.5' corresponde aos botões estáticos 'editar' e 'deletar'.
     *
     * @returns
     */
    static getTableHead = (): TableHead => ({
        simple: 'Header 1',
        options: 'Header 2',
        render: 'Header 3',
    });

    /**
     * Retorna o dado de cada célula por coluna no TableBody.
     *
     * @returns
     */
    getTableData = (): object => ({
        simple: 'Data 1',
        options: {
            withLink: false,
            text: 'Data 2',
        },
        render: {
            render: () => (
                <Chip
                    color="primary"
                    label="Data 3"
                />
            ),
        },
    });
}

export default Model;
