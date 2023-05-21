import { ComponentProps } from "react";
import styles from "./index.module.scss";

type Props = {} & ComponentProps<"label">;

export const MediumGrayLabel = ({ children }: Props) => {
  return <label className={styles.label}>{children}</label>;
};
