import { MediumGrayLabel } from "@/components/atoms/Label/MediumGrayLabel";
import { UseFormRegister } from "react-hook-form";
import { ValidationError } from "../ValidationError";
import styles from "./index.module.scss";
import { InputMediumGrayTextArea } from "@/components/atoms/Input/InputMediumGrayTextArea";
import { Require } from "@/components/atoms/Label/Require";

export const InputTextAreaGroupDesignType = {
  gray: "gray",
} as const;

type InputTextAreaGroupDesignType = keyof typeof InputTextAreaGroupDesignType;
type Props = {
  designType: InputTextAreaGroupDesignType;

  name: string;
  displayName: string;
  placeholder: string;

  require: boolean;
  register: UseFormRegister<any>;
  validation: { [key: string]: any };
  error?: string;
};

export const InputTextAreaGroup = ({
  designType,

  name,
  validation,

  require,
  register,
  displayName,
  placeholder,
  error,
}: Props) => {
  if (designType === InputTextAreaGroupDesignType.gray) {
    return (
      <div className={styles.inputTextGroup}>
        <MediumGrayLabel>
          {displayName}
          {require ? <Require /> : <></>}
        </MediumGrayLabel>
        <InputMediumGrayTextArea
          register={register}
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
