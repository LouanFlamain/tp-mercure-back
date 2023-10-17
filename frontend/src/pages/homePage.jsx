import LeftPanel from "../components/leftPanel/LeftPanel";
import MessagePanel from "../components/messagePanel/MessagePanel";

const Homepage = () => {
  return (
    <section className="w-full h-screen flex p-8">
      <div className="flex w-full">
        <LeftPanel />
        <MessagePanel />
      </div>
    </section>
  );
};

export default Homepage;
