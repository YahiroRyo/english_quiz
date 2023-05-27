import { FileUploadIcon } from "@/components/atoms/Icon/FileUploadIcon";
import styles from "./index.module.scss";
import { MediumGrayLabel } from "@/components/atoms/Label/MediumGrayLabel";
import { UseFormRegister } from "react-hook-form";
import { ValidationError } from "../ValidationError";
import { RedButton } from "@/components/atoms/Button/RedButton";
import { useRef } from "react";

type Props = {
  name: string;
  displayName: string;
  onChange: React.ChangeEventHandler<HTMLInputElement>;

  register: UseFormRegister<any>;
  validation: { [key: string]: any };
  error?: string;
};

export const InputImage = ({
  name,
  validation,
  onChange,

  register,
  displayName,
  error,
}: Props) => {
  const inputElement = useRef<HTMLInputElement>(null);

  return (
    <div className={styles.input}>
      <input
        type="file"
        accept="image/jpg,image/jpeg,image/png"
        hidden={true}
        {...register(name, validation)}
        ref={inputElement}
        onChange={onChange}
      />

      <div className={styles.inputButtonWrapper}>
        <RedButton
          onClick={() => {
            inputElement.current?.click();
          }}
          type="button"
        >
          <div className={styles.inputButton}>
            <FileUploadIcon fill="#fff" width={16} />
            <MediumGrayLabel>{displayName}</MediumGrayLabel>
          </div>
        </RedButton>

        {error ? <ValidationError error={error} /> : <></>}
      </div>
    </div>
  );
};
