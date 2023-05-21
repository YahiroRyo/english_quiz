type ErrorDict = { [key: string]: string };

export type ErrorResponse = {
  message: string;
  data: ErrorDict;
};

export const errorDictToString = (data: ErrorDict) => {
  let result = "";

  Object.keys(data).forEach((key) => {
    result += `・${key} : ${data[key]}`;
  });

  return result;
};
