import { InputMediumGrayText } from "@/components/atoms/Input/InputMediumGrayText";
import { MediumGrayLabel } from "@/components/atoms/Label/MediumGrayLabel";
import { UseFormRegister } from "react-hook-form";
import { ValidationError } from "../ValidationError";
import styles from "./index.module.scss";
import { Require } from "@/components/atoms/Label/Require";

export const InputTextGroupDesignType = {
  gray: "gray",
} as const;

type InputTextGroupDesignType = keyof typeof InputTextGroupDesignType;
type Props = {
  designType: InputTextGroupDesignType;

  type: string;
  name: string;
  displayName: string;
  placeholder: string;
  require: boolean;

  register: UseFormRegister<any>;
  validation: { [key: string]: any };
  error?: string;
};

export const InputTextGroup = ({
  designType,

  type,
  name,
  validation,

  require,
  register,
  displayName,
  placeholder,
  error,
}: Props) => {
  if (designType === InputTextGroupDesignType.gray) {
    return (
      <div className={styles.inputTextGroup}>
        <MediumGrayLabel>
          {displayName}
          {require ? <Require /> : <></>}
        </MediumGrayLabel>
        <InputMediumGrayText
          register={register}
          type={type}
          validation={validation}
          placeholder={placeholder}
          name={name}
        />
        {error ? <ValidationError error={error} /> : <></>}
      </div>
    );
  }

  throw Error("The specified designType is undefined.");
};
