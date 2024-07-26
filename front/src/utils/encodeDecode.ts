export function encode(data: any) {
    return btoa(JSON.stringify(data));
}
  
export function decode(data: any) {
    return JSON.parse(atob(data));
}