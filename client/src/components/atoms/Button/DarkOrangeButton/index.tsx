import { ComponentProps } from "react";
import styles from "./index.module.scss";

type Props = ComponentProps<"button">;

export const DarkOrangeButton = ({ children, disabled }: Props) => {
  return (
    <button className={styles.button} disabled={disabled}>
      {children}
    </button>
  );
};
