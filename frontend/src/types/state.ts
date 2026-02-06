
export interface State {
    [key: string]: any;
}

export interface StateAction {
    type: string,
    payload: any,
}
