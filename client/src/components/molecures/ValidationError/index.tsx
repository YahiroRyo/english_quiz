import { ErrorIcon } from "@/components/atoms/Icon/ErrorIcon";
import { MediumRedBoldText } from "@/components/atoms/Text/MediumRedBoldText";
import styles from "./index.module.scss";

type Props = {
  error?: string;
};

export const ValidationError = ({ error }: Props) => {
  return (
    <div className={styles.error}>
      <ErrorIcon />
      <MediumRedBoldText>{error}</MediumRedBoldText>
    </div>
  );
};
