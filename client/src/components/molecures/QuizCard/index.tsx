import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import styles from "./index.module.scss";
import {
  faCheckCircle,
  faQuestionCircle,
  faTimesCircle,
} from "@fortawesome/free-solid-svg-icons";
import Link from "next/link";
import { ROUTE_PATHNAME } from "@/constants/route";
import { MediumDarkBoldText } from "@/components/atoms/Text/MediumDarkBoldText";

type Props = {
  quizId: number;
  quizCategoryId: number;
  question: string;
  isCorrect?: boolean;
};

export const QuizCard = ({
  quizId,
  quizCategoryId,
  question,
  isCorrect,
}: Props) => {
  const CorrectIcon = () => {
    if (isCorrect === undefined) {
      return (
        <FontAwesomeIcon color="#666666" size="2x" icon={faQuestionCircle} />
      );
    }
    if (isCorrect) {
      return <FontAwesomeIcon color="green" size="2x" icon={faCheckCircle} />;
    }
    return <FontAwesomeIcon color="blue" size="2x" icon={faTimesCircle} />;
  };

  return (
    <Link
      className={styles.quizCardLink}
      href={`${ROUTE_PATHNAME.QUIZ}/question?quizCategoryId=${quizCategoryId}&quizId=${quizId}`}
    >
      <div className={styles.quizCard}>
        <CorrectIcon />
        <MediumDarkBoldText>
          {`次の文章を英訳しなさい : ${question}`}
        </MediumDarkBoldText>
      </div>
    </Link>
  );
};
