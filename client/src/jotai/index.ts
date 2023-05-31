export const JOTAI_KEY = {
  USER: "user",
};

export const isReady = (key: string, atomValue: any) => {
  if (typeof window === "undefined") {
    return false;
  }

  if (!(atomValue instanceof Array) && atomValue instanceof Object) {
    return localStorage.getItem(key) === JSON.stringify(atomValue);
  }
  return localStorage.getItem(key) === String(atomValue);
};
