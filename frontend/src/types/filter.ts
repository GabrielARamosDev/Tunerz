
export interface Page {
    [key: string]: any;
}

export interface Filter {
    currentPage: Page;
    countryIds: number[];
    stateIds: number[];
    cityIds: number[];
    schoolIds: number[];
    seasonIds: number[];
    leagueIds: number[];
    gameIds: number[];
}
