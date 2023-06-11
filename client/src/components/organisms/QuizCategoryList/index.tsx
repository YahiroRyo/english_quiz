import styles from "./index.module.scss";
import Link from "next/link";
import { ROUTE_PATHNAME } from "@/constants/route";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTag } from "@fortawesome/free-solid-svg-icons";
import { SmallBlackBoldText } from "@/components/atoms/Text/SmallBlackBoldText";
import { QuizCategory } from "@/types/quiz";
import { useRouter } from "next/router";

type Props = {
  quizCategoryList: QuizCategory[];
};

export const QuizCategoryList = ({ quizCategoryList }: Props) => {
  const router = useRouter();
  const { quizCategoryId } = router.query;

  return (
    <div className={styles.quizCategoryListWrapper}>
      <div className={styles.quizCategoryList}>
        {quizCategoryList.map((quizCategory) => (
          <Link
            className={`${styles.quizCategoryLink} ${
              Number(quizCategoryId) === quizCategory.quizCategoryId
                ? styles.quizCategoryLinkSelected
                : ""
            }`}
            key={quizCategory.quizCategoryId}
            href={`${ROUTE_PATHNAME.QUIZ}/quizCategory?quizCategoryId=${quizCategory.quizCategoryId}`}
          >
            <SmallBlackBoldText>
              <div className={styles.quizCategoryLinkText}>
                <FontAwesomeIcon icon={faTag} />
                {quizCategory.name}
              </div>
            </SmallBlackBoldText>
          </Link>
        ))}
      </div>
    </div>
  );
};
